<?php

namespace App\Form;

use App\Entity\Fournisseur;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class FournisseurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email')
            ->add('password')
            ->add('nom')
            ->add('prenom')
            ->add('numtel1')
            ->add('numtel2')
            ->add('etat', HiddenType::class, ['empty_data' => 'active'])
            ->add('adresse')
            ->add('datenaissance')
            ->add('nomrestaurant')
            ->add('tempsapprox')

            ->add('imageFile' , VichImageType::class)
            ->add('region',EntityType::class,array(
                'class' => Ville::class,

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
