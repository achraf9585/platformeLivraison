<?php
/**
 * Created by PhpStorm.
 * User: Achraf Zaafrane
 * Date: 14/05/2019
 * Time: 01:20
 */

namespace App\Controller;





use App\Entity\ChangePassword;
use App\Entity\Fournisseur;
use App\Form\ClientType;
use App\Form\FourEditType;
use App\Form\RegistrationClientFormType;
use App\Form\ResetPasswordType;
use App\Repository\ClientRepository;
use App\Repository\CommandeRepository;
use App\Repository\FournisseurRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class AccountController extends  AbstractController
{

    /**
     * @Route("/four/show", name="gererfour_show", methods={"GET"})
     */
    public function show(FournisseurRepository $fournisseurRepository , CommandeRepository $commandeRepository): Response{
        $etats=$commandeRepository->findBy(array('etat'=>'confirmer'));

        $usr= $this->get('security.token_storage')->getToken()->getUser();

        $fournisseur=  $fournisseurRepository->findOneBy(array('id'=>$usr));
        return $this->render('fournisseur/showgerer.html.twig', [
            'fournisseur' => $fournisseur,
            'etats' => $etats,
        ]);
    }


    /**
     * @Route("/four/edit", name="four_gerer", methods={"GET","POST"})
     */
    public function edit(Request $request, CommandeRepository $commandeRepository,FournisseurRepository $fournisseurRepository): Response
    {
        $etats=$commandeRepository->findBy(array('etat'=>'confirmer'));

        $usr= $this->get('security.token_storage')->getToken()->getUser();

        $fournisseur=  $fournisseurRepository->findOneBy(array('id'=>$usr));


        $form = $this->createForm(FourEditType::class, $fournisseur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('commande_per', [
                'id' => $fournisseur->getId(),
            ]);
        }

        return $this->render('fournisseur/editgerer.html.twig', [
            'fournisseur' => $fournisseur,
            'form' => $form->createView(),
            'etats'=>$etats


        ]);
    }
    /**
     * @Route("four/mdpedit", name="four_mdp", methods={"GET","POST"})
     */
    public function editAction(Request $request , FournisseurRepository $fournisseurRepository ,UserPasswordEncoderInterface $encoder)
    {
        $usr= $this->get('security.token_storage')->getToken()->getUser();

        $admin=$fournisseurRepository->findOneBy(array('id'=>$usr));
        $changePasswordModel = new ChangePassword();
        $form = $this->createForm(ResetPasswordType::class, $changePasswordModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encoded = $encoder->encodePassword($admin,$changePasswordModel->newPassword);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($admin);

            $admin->setPassword($encoded);
            $entityManager->flush();

            return $this->redirectToRoute('commande_per', [
            ]);
        }






        return $this->render('fournisseur/mdpchange.html.twig', array(
            'form' => $form->createView(),
        ));
    }













    /**
     * @Route("/client/show", name="gerercli_show", methods={"GET"})
     */
    public function showCli(ClientRepository $clientRepository ): Response{

        $usr= $this->get('security.token_storage')->getToken()->getUser();

        $client=  $clientRepository->findOneBy(array('id'=>$usr));
        return $this->render('client/showgerer.html.twig', [
            'client' => $client,
        ]);
    }


    /**
     * @Route("/client/edit", name="cli_gerer", methods={"GET","POST"})
     */
    public function editCli(Request $request,ClientRepository $clientRepository): Response
    {

        $usr= $this->get('security.token_storage')->getToken()->getUser();

        $client=  $clientRepository->findOneBy(array('id'=>$usr));


        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('home', [
                'id' => $client->getId(),
            ]);
        }

        return $this->render('client/editgerer.html.twig', [
            'client' => $client,
            'form' => $form->createView(),
            'editMode'=>$client->getId()!=null,


        ]);
    }


    /**
     * @Route("client/edit/password", name="cli_mdp", methods={"GET","POST"})
     */
    public function editclimdp(Request $request , ClientRepository $clientRepository ,UserPasswordEncoderInterface $encoder)
    {
        $usr= $this->get('security.token_storage')->getToken()->getUser();

        $client=$clientRepository->findOneBy(array('id'=>$usr));
        $changePasswordModel = new ChangePassword();
        $form = $this->createForm(ResetPasswordType::class, $changePasswordModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $encoded = $encoder->encodePassword($client,$changePasswordModel->newPassword);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($client);

            $client->setPassword($encoded);
            $entityManager->flush();

            return $this->redirectToRoute('home', [
            ]);
        }






        return $this->render('client/resetpassword.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}