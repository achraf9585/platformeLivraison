<?php

namespace App\Controller;

use App\Entity\Supplement;
use App\Form\SupplementType;
use App\Repository\CommandeRepository;
use App\Repository\SupplementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Asset\PackageInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

/**
 * @Route("/supplement")
 */
class SupplementController extends AbstractController
{
    /**
     * @Route("/", name="supplement_index", methods={"GET"})
     */
    public function index(SupplementRepository $supplementRepository, CommandeRepository $commandeRepository,Request $request, PaginatorInterface $paginator): Response
    {
        /**
         * @var \App\Entity\Fournisseur $user
         */
        $user = $this->getUser();
        $usr= $this->get('security.token_storage')->getToken()->getUser();
        $usr->getId();
        $ds=new \DateTime();

        $etats=$commandeRepository->findBy(array('etat'=>'confirmer'));
        $supplements=$supplementRepository->findBy(array('fournisseur'=>$usr));

        $properties=$paginator->paginate($supplements,
            $request->query->getInt('page',1),
            4
        );
        return $this->render('supplement/index.html.twig', [
            'supplements'=> $supplements,
            'properties' => $properties ,
            'etats' => $etats ,
        ]);
    }

    /**
     * @Route("/new", name="supplement_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $usr= $this->get('security.token_storage')->getToken()->getUser();
        $usr->getId();
        $supplement = new Supplement();
        $form = $this->createForm(SupplementType::class, $supplement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($supplement);
            $supplement->setFournisseur($usr);
            $entityManager->flush();

            return $this->redirectToRoute('supplement_index');
        }

        return $this->render('supplement/new.html.twig', [
            'supplement' => $supplement,
            'form' => $form->createView(),
            'editMode'=> $supplement->getId()!=null
        ]);
    }

    /**
     * @Route("/{id}", name="supplement_show", methods={"GET"})
     */
    public function show(Supplement $supplement): Response
    {
        return $this->render('supplement/show.html.twig', [
            'supplement' => $supplement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="supplement_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Supplement $supplement): Response
    {
        $form = $this->createForm(SupplementType::class, $supplement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('supplement_index', [
                'id' => $supplement->getId(),
            ]);
        }

        return $this->render('supplement/edit.html.twig', [
            'supplement' => $supplement,
            'form' => $form->createView(),
            'editMode'=> $supplement->getId()!=null
        ]);
    }

    /**
     * @Route("/{id}", name="supplement_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Supplement $supplement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$supplement->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($supplement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('supplement_index');
    }
}
