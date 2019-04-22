<?php

namespace App\Form;

use App\Entity\Livreur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Tests\Extension\Core\Type\NumberTypeTest;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email' )
            ->add('nom')
            ->add('prenom')
            ->add('etat', HiddenType::class, ['empty_data' => 'en attente'])
            ->add('commission', HiddenType::class, ['empty_data' => 0])
                ->add('numtel1',TextType::class,['label' => ' Téléphone 1'])
            ->add('numtel2',null ,array('required'=>false ,'label' => ' Téléphone 2'))
            ->add('typevehicule',ChoiceType::class,[
                'choices'  => [
                    'voiture' => 'Voiture',
                    'Moto' => 'Moto',
                    'velo' => 'Velo',
                ],
                'expanded' => true,
                'multiple' => false

            ])

            ->add('typepapier',ChoiceType::class,[
                'choices'  => [
                    'Carte identité national' => 'Carte identité national',
                    'Passeport' => 'Passeport',
                    'Carte sejour' => 'Carte sejour',
                ],
            ])
            ->add('numpapier')
            ->add('localisation')
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
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
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
            'data_class' => Livreur::class,
        ]);
    }
}
