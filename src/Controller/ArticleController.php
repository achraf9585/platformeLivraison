<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use App\Repository\CommandeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



/**
 * @Route("/article")
 */
class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="plat_index", methods={"GET"})
     */
    public function index(ArticleRepository $platRepository,CommandeRepository $commandeRepository ,Request $request, PaginatorInterface $paginator): Response
    {
        /**
         * @var \App\Entity\Fournisseur $user
         */
        $user = $this->getUser();
        $ds=new \DateTime();

        $etats=$commandeRepository->findBy(array('etat'=>'confirmer'));
        $articles=$platRepository->findBy(array('fournisseur' => $user));
     /*  foreach ($article as $key=>$value){
            $value->setImage(base64_encode(stream_get_contents($value->getImage())));
        }*/
        $properties=$paginator->paginate($articles,
            $request->query->getInt('page',1),
            4
        );

        return $this->render('article/index.html.twig', [
            'articles' => $articles,
            'properties'=>$properties,
            'etats'=>$etats,

        ]);
    }

    /**
     * @Route("/new", name="plat_new", methods={"GET","POST"})
     */
    public function new(Request $request)
    {
        $usr= $this->get('security.token_storage')->getToken()->getUser();
        $usr->getId();
        $article = new Article();
        $form = $this->createForm(ArticleType::class, $article , array('user'=>$this->getUser()));
        $form->handleRequest($request);
        /*foreach ($article as $key=>$value){
            $value->setImage(base64_encode(stream_get_contents($value->getImage())));
        }*/

          if ($form->isSubmitted() && $form->isValid()) {

              $entityManager = $this->getDoctrine()->getManager();
              $entityManager->persist($article);
              $article->setFournisseur($usr);
              $entityManager->flush();

              return $this->redirectToRoute('plat_index');


          }



        return $this->render('article/new.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'editMode'=>$article->getId() !== null

        ]);
    }



    /**
     * @Route("/{id}", name="plat_show", methods={"GET"})
     */
    public function show(Article $article): Response
    {
        return $this->render('article/show.html.twig', [
            'article' => $article,

        ]);
    }

    /**
     * @Route("/edit/{id}", name="plat_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Article $article): Response
    {
        $form = $this->createForm(ArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('plat_index', [
                'id' => $article->getId(),

            ]);
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView(),
            'editMode'=>$article->getId() !== null
        ]);
    }

    /**
     * @Route("/{id}", name="plat_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Article $plat): Response
    {
        if ($this->isCsrfTokenValid('delete'.$plat->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($plat);
            $entityManager->flush();
        }

        return $this->redirectToRoute('plat_index');
    }
}
