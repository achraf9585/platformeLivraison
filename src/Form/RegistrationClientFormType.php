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
            ->add('email' )
            ->add('nom')
            ->add('prenom')
            ->add('numtel1',TextType::class,['label' => ' Téléphone 1'])
            ->add('numtel2',null ,array('required'=>false ,'label' => ' Téléphone 2'))
            ->add('adresse')
            ->add('datenaissance', DateType::class, [
                'widget' => 'single_text',

            ])

            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'le mot de passe doit contenir au moins {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('confirm_password',PasswordType::class)

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