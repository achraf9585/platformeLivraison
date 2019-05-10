<?php

namespace App\Form;

use App\Entity\Region;
use App\Entity\Ville;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VilleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libele')
            ->add('region',EntityType::class,array(
                'class' => Region::class,

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
            'data_class' => Ville::class,
        ]);
    }
}
