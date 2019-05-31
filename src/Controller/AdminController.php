<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Commande_article;
use App\Entity\Region;
use App\Form\ArticleType;
use App\Form\CommandeType;
use App\Form\FournisseurType;
use App\Form\ResetPasswordType;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use App\Repository\ClientRepository;
use App\Repository\CommandeRepository;
use App\Repository\FournisseurRepository;
use App\Repository\LivreurRepository;
use App\Repository\RegionRepository;
use App\Repository\VilleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminController extends Controller
{

    /**
     * @Route("/client", name="client")
     */

    public function cli(VilleRepository $villeRepository,RegionRepository $regionRepository)
    {
        $villes= $villeRepository->findVilleCli();
        $regions=$regionRepository->findAll();

        return $this->render('client/index.html.twig', [
            'controller_name' => 'AdminController',
            'villes' => $villes,
            'nbr'=>$this->panierCount(),
            'regions' => $regions,
        ]);
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index(FournisseurRepository $fournisseurRepository, LivreurRepository $livreurRepository , ClientRepository $clientRepository,CommandeRepository $commandeRepository)
    {
        $fournisseursnbr=$fournisseurRepository->nbrfour();
        $clientnbr= $clientRepository->nbrcli();
        $livreurnbr= $livreurRepository->nbrcli();
        $commandenbr=$commandeRepository->nbrcom();
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
            'fournisseursnbr' => $fournisseursnbr,
            'clientnbr' => $clientnbr,
            'livreurnbr' => $livreurnbr,
            'commandenbr' => $commandenbr,
        ]);
    }
    /**
     * @Route("/",name="home")
     */
    public function loginAdmin(AuthenticationUtils $authenticationUtils): Response
    {
            // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/loginadmin.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }


// TO DO IN RAMADHANE KARIM YYA KARIM !!!
    /**
     * @Route("/client/cherche",name="cherch")
     */
public  function  search(FournisseurRepository $fournisseurRepository,Request $request){
    $m= $request->query->get('m');
     $fournisseurs= $fournisseurRepository->findregion($m);
    return $this->render('client/cherche.html.twig', [
        'fournisseurs' => $fournisseurs,
        'nbr'=>$this->panierCount(),
        'm' => $m,

    ]);
}



    /**
     * @Route("/client/recherche", name="lstarticle_show")
     */
       public function show(ArticleRepository $articleRepository, CategorieRepository $categorieRepository): Response
    {
        $articles= $articleRepository->findAll();
        $categories=$categorieRepository->findAll();
        return $this->render('client/lstplats.html.twig', [
            'articles' => $articles,
            'categories' => $categories,
            'nbr'=>$this->panierCount(),
        ]);
    }



    /**
     * @Route("/client/panier/supprimer", name="panier_supprimer")
     */
    public  function supprimerdePanier(Request $request){
        $id= $request->query->get('id');
        $session = $this->get('session');
        if (!$session->has('panier')) {$session->set('panier',array());}
        $panier = $session->get('panier');
        unset($panier[$id]);
        $session->set('panier',$panier);
        return( $this->redirectToRoute('panier_show'));
    }

    /**
     * @Route("/client/panier", name="panier_show", methods={"GET","POST"})
     */
    public function getPanier(ArticleRepository $articleRepository,Request $request){



        $articles=[];
        $qts=[];
        $session =  $this->get('session');
        if (!$session->has('panier')) {$session->set('panier',array());}
        $panier = $session->get('panier');
        $total=0;
        $k=0;
        foreach ($panier as $id => $qte){
            $article= $articleRepository->findOneBy(['id' =>$id]);
            array_push($articles,$article);
            array_push($qts,$qte);
            $total+=$qte*$article->getPrix();
        }



        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande );
 //mezelet


        $form->handleRequest($request);
        $usr= $this->get('security.token_storage')->getToken()->getUser();
        $usr->getId();
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commande);
            $commande->setClient($usr);
            $commande->setTotal($total+6);
            $entityManager->flush();

// *************//

            foreach ($panier as $id => $qte){
                $comart= new Commande_article();


                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($comart);
                $comart->setArticle($article);
                $comart->setCommande($commande);
                $comart->setQte($qte);
                $entityManager->flush();
            }
            //*****************//
          /*  for($i=0;$i<sizeof($qts);$i++)
            {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($comart);
                $comart->setArticle($articles[$i]);
                $comart->setCommande($commande);
                $comart->setQte($qts[$i]);
                $entityManager->flush();
            }*/

            return $this->redirectToRoute('cherch');
        }
        return $this->render('client/panier.html.twig', [
            'articles' => $articles,
            'total' => $total,
            'nbr'=>$this->panierCount(),
            'qts' => $qts,
            'form' => $form->createView(),

        ]);
    }

    /**
     * @Route("/client/panier/ajout", name="panier_ajout")
     */
    public  function ajoutauPanier(Request $request){
        $id= $request->query->get('id');
        $idf= $request->query->get('idf');
        $session = $this->get('session');
        if (!$session->has('panier')) {$session->set('panier',array());}
        $panier = $session->get('panier');
        if(array_key_exists($id,$panier)) { $panier[$id]+=1; }
        else{  $panier[$id]=1; }
        $session->set('panier',$panier);
     return( $this->redirectToRoute('lstarticle_show',array('idf' => $idf)));
    }

    /**
     * @Route("/client/panier/plus", name="panier_plus")
     */
    public  function plusPanier(Request $request){
        $id= $request->query->get('id');
        $session = $this->get('session');
        if (!$session->has('panier')) {$session->set('panier',array());}
        $panier = $session->get('panier');
        if(array_key_exists($id,$panier)) { $panier[$id]+=1; }
        else{  $panier[$id]=1; }
        $session->set('panier',$panier);
        return( $this->redirectToRoute('panier_show'));
    }

    /**
     * @Route("/client/panier/minus", name="panier_minus")
     */
    public  function minusPanier(Request $request){
        $id= $request->query->get('id');
        $session = $this->get('session');
        if (!$session->has('panier')) {$session->set('panier',array());}
        $panier = $session->get('panier');
        if(array_key_exists($id,$panier)) { $panier[$id]-=1; }
        if($panier[$id]==0){unset($panier[$id]);}
        $session->set('panier',$panier);
        return( $this->redirectToRoute('panier_show'));
    }










    /**
     * @Route("admin/edit", name="account_reset", methods={"GET","POST"})
     */
    public function editAction(Request $request )
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $form = $this->createForm(ResetPasswordType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $passwordEncoder = $this->get('security.password_encoder');
            $oldPassword = $request->request->get('')['oldPassword'];

            // Si l'ancien mot de passe est bon
            if ($passwordEncoder->isPasswordValid($user,$oldPassword)) {
                $newEncodedPassword = $passwordEncoder->encodePassword($user, $user->getPassword());
                $user->setPassword($newEncodedPassword);

                $em->persist($user);
                $em->flush();

                $this->addFlash('notice', 'Votre mot de passe à bien été changé !');

                return $this->redirectToRoute('admin');
            } else {
                $form->addError(new FormError('Ancien mot de passe incorrect'));
            }
        }

        return $this->render('admin/resetpassword.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function  panierCount(){
        $session = $this->get('session');
        $nbr=0;
        if ($session->has('panier')) {$nbr=count($session->get('panier'));}
        return($nbr);
    }





}
