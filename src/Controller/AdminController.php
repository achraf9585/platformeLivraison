<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\ChangePassword;
use App\Entity\Commande;
use App\Entity\Commande_article;
use App\Entity\CommandeArticleSupplement;
use App\Entity\Commentaire;
use App\Entity\Fournisseur;
use App\Entity\Region;
use App\Form\ArticleType;
use App\Form\CommandeType;
use App\Form\Commentaire1Type;
use App\Form\CommentaireType;
use App\Form\FournisseurType;
use App\Form\ResetPasswordType;
use App\Repository\AdminRepo;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use App\Repository\ClientRepository;
use App\Repository\CommandeRepository;
use App\Repository\CommentaireRepository;
use App\Repository\FormuleRepository;
use App\Repository\FournisseurRepository;
use App\Repository\LivreurRepository;
use App\Repository\RegionRepository;
use App\Repository\SupplementRepository;
use App\Repository\VilleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use PhpParser\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
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
    public function loginCli(VilleRepository $villeRepository,RegionRepository $regionRepository): Response
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


// TO DO IN RAMADHANE KARIM YYA KARIM !!!
    /**
     * @Route("/client/cherche",name="cherch")
     */
public  function  search(FournisseurRepository $fournisseurRepository,CommentaireRepository $commentaireRepository,Request $request){
    $idf= $request->query->get('idf');
$nbrcomments=$commentaireRepository->nbrcomment();
    $m= $request->query->get('m');
     $fournisseurs= $fournisseurRepository->findregion($m);
    return $this->render('client/cherche.html.twig', [
        'fournisseurs' => $fournisseurs,
        'nbr'=>$this->panierCount(),
        'm' => $m,
        'nbrcomments' => $nbrcomments,

    ]);
}



    /**
     * @Route("/client/recherche", name="lstarticle_show")
     */
       public function show(ArticleRepository $articleRepository,CommentaireRepository $commentaireRepository, CategorieRepository $categorieRepository,FournisseurRepository $fournisseurRepository,Request $request): Response
    {
        $m= $request->query->get('idf');
        $articles= $articleRepository->findBy(array('fournisseur'=>$m,'etatArticle'=>'Activé'));
        $categories=$categorieRepository->findBy(array('fournisseur'=>$m,'etat'=>'Activé'));

        $comment= $request->query->get('comment');
        $note= $request->query->get('note');
        $idf= $request->query->get('idf');

/*
        $usr= $this->get('security.token_storage')->getToken()->getUser();
        $usr->getId();
        $commentaire= new Commentaire();
        $forme = $this->createForm(CommentaireType::class, $commentaire );
        if ($forme->isSubmitted() && $forme->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $commentaire->setClient($usr);
            $commentaire->setContenu($comment);
            $commentaire->setNote($note);

            $entityManager->flush();
        }

*/
$commentaires=$commentaireRepository->findBy(array('fournisseur'=>$idf));

        $usr= $this->get('security.token_storage')->getToken()->getUser();
        $fournisseur = new Fournisseur();
        $fournisseur= $fournisseurRepository->findOneBy(['id' =>$idf]);


        $commentaire = new Commentaire();
        $form = $this->createForm(Commentaire1Type::class, $commentaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commentaire);
            $commentaire->setClient($usr);
            $commentaire->setFournisseur($fournisseur);
            $entityManager->flush();

            return $this->redirectToRoute('lstarticle_show');
        }
        return $this->render('client/lstplats.html.twig', [
            'articles' => $articles,
            'categories' => $categories,
            'nbr'=>$this->panierCount(),
            'form' => $form->createView(),
            'commentaires' => $commentaires,
            'm' => $m,
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
    public function getPanier(ArticleRepository $articleRepository,Request $request,SupplementRepository $supplementRepository,FormuleRepository $formuleRepository){



        $articles=[];
        $qts=[];
        $suppse=[];
        $formule=$formuleRepository->findOneBy(array('id'=>1));
        $session =  $this->get('session');
        if (!$session->has('panier')) {$session->set('panier',array());}
        $panier = $session->get('panier');
        $total=0;
        $k=0;
        foreach ($panier as $id => $qte){
            $article= $articleRepository->findOneBy(['id' =>$id]);
            array_push($articles,$article);
            array_push($qts,$qte);
            $suppsarticle = $session->get('supplements'.$article->getId());
            $supps=[];
            for($i=0;$i<count($suppsarticle);$i++){
                $supplement=$supplementRepository->findOneBy(array('id'=>$suppsarticle[$i]));
                $total=$total+($supplement->getPrix()*$qte);
                array_push($supps,$supplement);
            }
            array_push($suppse,$supps);



            $total+=$qte*$article->getPrix();
        }



        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande );
 //mezelet


        $form->handleRequest($request);
        $usr= $this->get('security.token_storage')->getToken()->getUser();
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commande);
            $commande->setClient($usr);
            $commande->setTotal(0);
            $entityManager->flush();

// *************//
            $index=0;
            foreach ($panier as $id => $qte){
                $comart= new Commande_article();

                $article= $articleRepository->findOneBy(['id' =>$id]);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($comart);
                $comart->setArticle($article);
                $comart->setCommande($commande);
                $comart->setQte($qte);
                $entityManager->flush();

                for ($i=0;$i<count($suppse[$index]);$i++){
                    $cas= new CommandeArticleSupplement();
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->persist($cas);
                    $cas->setCommandeArticle($comart);
                    $cas->setSupplement($suppse[$index][$i]);

                    $entityManager->flush();

                    // $suppse[$index][$i] --> supplement
                        //$article->getId() -->id article
                }

                $index=$index+1;


            }
            ///////-------------------
            $entityManager->persist($commande);
            $commande->setTotal($total+$formule->getFrais());
            $entityManager->flush();
            $this->getDoctrine()->getManager()->flush();



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
            $this->viderPanier();
            return $this->redirectToRoute('home');
        }
        return $this->render('client/panier.html.twig', [
            'articles' => $articles,
            'total' => $total,
            'nbr'=>$this->panierCount(),
            'qts' => $qts,
            'form' => $form->createView(),
            'suppse' => $suppse,
            'formule' => $formule,

        ]);
    }



    /**
     * @Route("/client/panier/ajout", name="panier_ajout")
     */
    public  function ajoutauPanier(Request $request,ArticleRepository $articleRepository){
        $id= $request->query->get('id');
        $idf= $request->query->get('idf');
        $session = $this->get('session');
        if (!$session->has('panier')) {$session->set('panier',array());}
        $panier = $session->get('panier');
        $article= $articleRepository->findOneBy(['id' =>$id]);
        if (!$session->has("supplements".$article->getId())) {$session->set("supplements".$article->getId(),array());}
        if(array_key_exists($id,$panier)) { $panier[$id]+=1; }
        else{
            $panier[$id]=1;
            $supps=[];
            for($i=0;$i<$article->getSupplements()->count();$i++){
                $supp=$article->getSupplements()[$i];
                $bo= $request->get($article->getId().$supp->getId());
                if($bo){
                    array_push($supps,$supp->getId());
                }
            }
            $session->set("supplements".$article->getId(),$supps);
        }
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

    public  function viderPanier(){
        $session = $this->get('session');
        $session->set('panier',array());
    }










    /**
     * @Route("admin/edit", name="account_reset", methods={"GET","POST"})
     */
    public function editAction(Request $request , AdminRepo $adminRepo ,UserPasswordEncoderInterface $encoder)
    {
        $usr= $this->get('security.token_storage')->getToken()->getUser();

        $admin=$adminRepo->findOneBy(array('id'=>$usr));
        $changePasswordModel = new ChangePassword();
        $form = $this->createForm(ResetPasswordType::class, $changePasswordModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encoded = $encoder->encodePassword($admin,$changePasswordModel->newPassword);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($admin);

            $admin->setPassword($encoded);
                $entityManager->flush();

            return $this->redirectToRoute('admin', [
            ]);
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


    /**

     * @Route("/statistique", name="stat", methods={"GET","POST"})
     */
public function nbrcommande(CommandeRepository $commandeRepository , Request $request){
    $count=array();
    $total=array();
    for($i=1;$i<=12;$i++){
        $count[$i]= 0;
        $total[$i]=0; }
    $commandes=$commandeRepository->findAll();
    foreach ($commandes  as $cmd ){
        $count[(int) $cmd->getDatecommande()->format('m')]++;
        $total[(int) $cmd->getDatecommande()->format('m')]+=$cmd->getTotal();
    }

    return $this->render('statistique/index.html.twig', array(
        'count' => $count,
        'total' => $total

    ));
}



}
