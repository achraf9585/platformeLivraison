<?php
/**
 * Created by PhpStorm.
 * User: Achraf Zaafrane
 * Date: 23/04/2019
 * Time: 10:27
 */

namespace App\Form;


use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationClientFormType extends AbstractType
{
    public function  buildForm(FormBuilderInterface $builder, array $options){

        $builder
            ->add('email' ,TextType::class, ['label'=>' Email'])
            ->add('nom', TextType::class, ['label'=>' Nom'])
            ->add('prenom' , TextType::class, ['label'=>' Prénom'])
            ->add('numtel1',TextType::class,['label' => ' Téléphone 1'])
            ->add('numtel2',null ,array('required'=>false ,'label' => ' Téléphone 2'))
            ->add('adresse', TextType::class, ['label'=>'Adresse'])
            ->add('datenaissance', DateType::class, [
                'label'=>'Date de naissance',
                'widget' => 'single_text',

            ])

            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmez votre mot de passe'],

                'mapped' => false,

                'constraints' => [


                    new NotBlank([
                        'message' => 'Entrer votre mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'le mot de passe doit contenir au moins {{ limit }} caractéres',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])

            ->add('terms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => new IsTrue(),
            ])
        ;
    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }


}