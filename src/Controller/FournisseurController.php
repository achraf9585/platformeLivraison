<?php

namespace App\Controller;

use App\Entity\Fournisseur;
use App\Form\FourEditType;
use App\Form\FournisseurType;
use App\Repository\FournisseurRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * @Route("/fournisseur")
 */
class FournisseurController extends AbstractController
{
    /**
     * @Route("", name="fournisseur_index", methods={"GET","POST"})
     */
    public function index(FournisseurRepository $fournisseurRepository,Request $request, PaginatorInterface $paginator,UserPasswordEncoderInterface $passwordEncoder): Response
    {
        $fournisseurs=$fournisseurRepository->findAll();
        $properties= $paginator->paginate(
            $fournisseurs,
            $request->query->getInt('page',1),
            5

        );
        $fournisseur = new Fournisseur();
        $form = $this->createForm(FournisseurType::class, $fournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $fournisseur->setPassword(
                $passwordEncoder->encodePassword(
                    $fournisseur,
                    $form->get('password')->getData()
                )
            );
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($fournisseur);
            $entityManager->flush();

            return $this->redirectToRoute('fournisseur_index');
        }

        return $this->render('fournisseur/index.html.twig', [
            'fournisseurs' => $fournisseurs,
            'region' => $fournisseur,
            'form' => $form->createView(),
            'properties' =>$properties,
            'editMode'=>$fournisseur->getId()!=null
        ]);
    }


    /**
     * @Route("/{id}", name="fournisseur_show", methods={"GET"})
     */
    public function show(Fournisseur $fournisseur): Response
    {
        return $this->render('fournisseur/show.html.twig', [
            'fournisseur' => $fournisseur,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="fournisseur_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Fournisseur $fournisseur): Response
    {
        $form = $this->createForm(FourEditType::class, $fournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fournisseur_index', [
                'id' => $fournisseur->getId(),
            ]);
        }

        return $this->render('fournisseur/edit.html.twig', [
            'fournisseur' => $fournisseur,
            'form' => $form->createView(),
            'editMode'=>$fournisseur->getId()!=null

        ]);
    }

    /**
     * @Route("/{id}", name="fournisseur_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Fournisseur $fournisseur): Response
    {
        if ($this->isCsrfTokenValid('delete'.$fournisseur->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($fournisseur);
            $entityManager->flush();
        }

        return $this->redirectToRoute('fournisseur_index');
    }
}
