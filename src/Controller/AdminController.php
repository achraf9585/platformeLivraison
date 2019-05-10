<?php

namespace App\Controller;

use App\Entity\Region;
use App\Repository\FournisseurRepository;
use App\Repository\RegionRepository;
use App\Repository\VilleRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class AdminController extends AbstractController
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
            'regions' => $regions,
        ]);
    }

    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
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
     * @Route("/client/recherche",name="cherch")
     */
public  function  search(FournisseurRepository $fournisseurRepository,Request $request){
    $m= $request->query->get('m');
     $fournisseurs= $fournisseurRepository->findregion($m);
    return $this->render('client/cherche.html.twig', [
        'fournisseurs' => $fournisseurs,
        'm' => $m,

    ]);
}




}
