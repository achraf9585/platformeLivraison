<?php

namespace App\Controller;

use App\Entity\Condi;
use App\Form\CondiType;
use App\Repository\CondiRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/condi")
 */
class CondiController extends AbstractController
{
    /**
     * @Route("", name="condi_index", methods={"GET"})
     */
    public function index(CondiRepository $condiRepository,Request $request,PaginatorInterface $paginator): Response
    {
        $regions=$condiRepository->findAll();
        $properties= $paginator->paginate(
            $regions,
            $request->query->getInt('page',1),
            5

        );
        return $this->render('condi/index.html.twig', [
            'condis' => $condiRepository->findAll(),
            'properties' =>$properties,
        ]);
    }

    /**
     * @Route("/new", name="condi_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $condi = new Condi();
        $form = $this->createForm(CondiType::class, $condi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($condi);
            $entityManager->flush();

            return $this->redirectToRoute('condi_index');
        }

        return $this->render('condi/new.html.twig', [
            'condi' => $condi,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="condi_show", methods={"GET"})
     */
    public function show(Condi $condi): Response
    {
        return $this->render('condi/show.html.twig', [
            'condi' => $condi,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="condi_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Condi $condi): Response
    {
        $form = $this->createForm(CondiType::class, $condi);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('condi_index', [
                'id' => $condi->getId(),
            ]);
        }

        return $this->render('condi/edit.html.twig', [
            'condi' => $condi,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="condi_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Condi $condi): Response
    {
        if ($this->isCsrfTokenValid('delete'.$condi->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($condi);
            $entityManager->flush();
        }

        return $this->redirectToRoute('condi_index');
    }
}
