<?php

namespace App\Form;

use App\Entity\Fournisseur;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class FournisseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, ['label'=>'Adresse email'])
            ->add('password', PasswordType::class,['label'=>'Mot de passe'])
            ->add('confirm_password', PasswordType::class,['label'=>'Confirmer Mot de passe'])
            ->add('nom',TextType::class,['label'=>'Nom'])
            ->add('prenom',TextType::class,['label'=>'Prénom'])
            ->add('numtel1',TextType::class,['label'=>'Numéro de téléphone 1'])
            ->add('numtel2',null ,array('required'=>false ,'label' => 'Numéro de téléphone 2'))
            ->add('etat', TextType::class,['label'=>'Etat'])
            ->add('adresse',TextType::class,['label'=>'Adresse'])
            ->add('datenaissance', DateType::class, ['label'=>'Date de fondation '])
            ->add('nomrestaurant',TextType::class, ['label'=>'Nom du restaurant'])
            ->add('tempsapprox', TextType::class, ['label'=>'Temps Approximatif'])
            ->add('etat', ChoiceType::class,
                [
                    'choices' =>    [
                        'Activé' => 'Activé',
                        'Désactivé' => 'Désactivé',]
                ])
            ->add('imageFile' , VichImageType::class, [
                'imagine_pattern' => 'test'
                ])
            ->add('region',EntityType::class,array(

                'class' => Ville::class,
                'label'    => 'Ville',
                /*'query_builder'=> function (EntityRepository $er)
                {
                    return $er->createQueryBuilder('u')
                        ->where("u.statut = 'oui' ");
                },*/
                'choice_label' =>'libele',
            ))


        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Fournisseur::class,
        ]);
    }
}
