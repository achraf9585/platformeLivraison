<?php
/**
 * Created by PhpStorm.
 * User: Achraf Zaafrane
 * Date: 29/04/2019
 * Time: 11:48
 */

namespace App\Controller;


use App\Entity\Client;
use App\Repository\ClientRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ClientController extends  AbstractController
{
    /**
     * @Route("/affclient", name="affcli_index")
     * @return Response
     */
    public function index(ClientRepository $clientRepository,PaginatorInterface $paginator,Request $request):Response
    {
        $clients=$clientRepository->findAll();
        $properties= $paginator->paginate(
            $clients,
            $request->query->getInt('page',1),
            5

        );

        return $this->render('client/affclient.html.twig', [
            'clients' => $clients,
            'properties' =>$properties,
        ]);
    }


    /**
     * @Route("affclient/{id}", name="client_show", methods={"GET"})
     */
    public function show(Client $client): Response
    {
        return $this->render('client/show.html.twig', [
            'client' => $client,
        ]);
    }


}