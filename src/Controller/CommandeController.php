<?php
/**
 * Created by PhpStorm.
 * User: Achraf Zaafrane
 * Date: 31/05/2019
 * Time: 04:34
 */

namespace App\Controller;


use App\Entity\Commande;
use App\Repository\CommandeArticleRepository;
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
     * @Route("/comm", name="commande_per", methods={"GET"})
     */
    public function showfour(CommandeRepository $commandeRepository, Request $request): Response
    {
        $usr= $this->get('security.token_storage')->getToken()->getUser();
        $usr->getId();



        $commandes=$commandeRepository->findfour($usr);
        return $this->render('commande/showfour.html.twig', [
            'commandes' => $commandes,
        ]);
    }

}