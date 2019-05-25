<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetPasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, array(
                'mapped' => false,
                'label' => 'Ancien mot de passe',
                'attr' => array(
                        'class' => 'form-control')


                )
            )
            ->add('password', RepeatedType::class, array(
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'Nouveau mot de passe'],
                'second_options' => ['label' => 'Confirmation nouveau mot de passe'],
                'invalid_message' => 'Les deux mots de passe doivent être identiques',
                'options' => array(
                    'attr' => array(
                        'class' => 'form-control'
                    )
                ),
                'required' => true,
            ))
            ->add('submit', SubmitType::class, array(
                'label' => 'Sauvegarder',
                'attr' => array(
                    'class' => 'btn btn-success btn-block',
                    'style' => 'margin-top: 20px; width: 70%; margin-left:110px;'
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
