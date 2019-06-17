<?php
/**
 * Created by PhpStorm.
 * User: Achraf Zaafrane
 * Date: 31/05/2019
 * Time: 04:34
 */

namespace App\Controller;


use App\Entity\Commande;
use App\Entity\CommandeArticleSupplement;
use App\Form\CommandefourType;
use App\Repository\CommandeArticleRepository;
use App\Repository\CommandeArticleSupplementRepository;
use App\Repository\CommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommandeController extends AbstractController
{
    /**
     * @Route("/commande", name="commande_index")
     * @return Response
     */
    public function index(CommandeRepository $commandeRepository,Request $request):Response
    {
        $commandes = $commandeRepository->findAll();
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes,
        ]);
    }

    /**
     * @Route("commande/{id}", name="commande_show", methods={"GET"})
     */
    public function show(Commande $commande,CommandeArticleRepository $commandeArticleRepository): Response
    {
        $commandess= $commandeArticleRepository->findBy(array('commande'=>$commande->getId()));
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
            'commandess' => $commandess,
        ]);
    }
    /**
     * @Route("/comm/", name="commande_per", methods={"GET"})
     */
    public function showfour(CommandeRepository $commandeRepository, Request $request): Response
    {

        $usr= $this->get('security.token_storage')->getToken()->getUser();
        $ds=new \DateTime();

        $etats=$commandeRepository->findBy(array('etat'=>'confirmer'));

        $commandes=$commandeRepository->findfour($usr);
        return $this->render('commande/showfour.html.twig', [
            'commandes' => $commandes,
            'etats' => $etats,
            'ds' => $ds,
        ]);
    }
    /**
     * @Route("/comm/{id}/edit", name="commande_edit_four", methods={"GET","POST"})
     */
    public function editcommfour(Commande $commande, Request $request): Response
    {

        $form = $this->createForm(CommandefourType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_per', [
                'id' => $commande->getId(),
            ]);
        }

        return $this->render('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
            'editMode'=>$commande->getId()!=null
        ]);
    }
    /**
     * @Route("/comm/{id}", name="commande_show_resto", methods={"GET"})
     */
    public function showresto(Commande $commande,CommandeArticleRepository $commandeArticleRepository , CommandeArticleSupplementRepository $commandeArticleSupplementRepository): Response
    {
        $commandess= $commandeArticleRepository->findBy(array('commande'=>$commande->getId()));

        return $this->render('commande/showresto.html.twig', [
            'commande' => $commande,
            'commandess' => $commandess,
        ]);
    }

    /**

     * @Route("/client/commandedetatil", name="cmd_client", methods={"GET","POST"})
     */
    public  function  cmdclient(Request $request , CommandeRepository $commandeRepository ): Response{
        $usr= $this->get('security.token_storage')->getToken()->getUser();

        $commandess= $commandeRepository->findBy(array('client'=>$usr));
        return $this->render('commande/cmdclient.html.twig', [
            'commandess' => $commandess,

        ]);
    }
}