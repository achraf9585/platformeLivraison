<?php

namespace App\Form;

use App\Entity\Formule;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormuleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('frais',TextType::class,array(
                'label'    => 'Frais du livraison ( en DT )',
            ))
            ->add('commission',TextType::class,array(
                'label'    => 'Commission du livreur ( en poucentage )',
            ))
            ->add('seuil',TextType::class,array(
                'label'    => 'Seuil d une commande ( en DT )',
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Formule::class,
        ]);
    }
}
