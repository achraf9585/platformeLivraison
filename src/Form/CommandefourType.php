<?php
/**
 * Created by PhpStorm.
 * User: Achraf Zaafrane
 * Date: 14/06/2019
 * Time: 10:02
 */

namespace App\Form;


use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommandefourType extends  AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

            ->add('etat', ChoiceType::class, [
                'choices' =>    [
                    'confirmée' => 'confirmée',
                    'annulée' => 'annulée',
                    'modifiée' => 'modifiée',
                ]
            ])



        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Commande::class,
        ]);
    }
}
