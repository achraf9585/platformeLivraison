<?php

namespace App\Form;

use App\Entity\Livreur;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
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
            ->add('email', TextType::class, ['label'=>'Adresse email'] )
            ->add('nom', TextType::class, ['label'=>'Nom'])
            ->add('prenom' , TextType::class, ['label'=>'Prénom'])
            ->add('etat', HiddenType::class, ['empty_data' => 'en attente'])
            ->add('commission', HiddenType::class, ['empty_data' => 0])

            ->add('numtel1',TextType::class,['label' => ' Téléphone 1'])
            ->add('numtel2',TextType::class, array('required'=>false ,'label' => ' Téléphone 2'))
            ->add('typevehicule',ChoiceType::class,[
                'choices'  => [
                    'voiture' => 'Voiture',
                    'Moto' => 'Moto',
                    'velo' => 'Velo',
                ],
                'expanded' => true,
                'multiple' => false

            ])
            ->add('typepapier', ChoiceType::class,[
                'choices'  => [
                    'Carte identité national' => 'Carte identité national',
                    'Passeport' => 'Passeport',
                    'Carte sejour' => 'Carte sejour',
                ],
            ])
            ->add('numpapier', NumberType::class, ['label'=>'Numéro de papier'])
            ->add('datenaissance', DateType::class, [
                'widget' => 'single_text',

            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Confirmez votre mot de passe'],
                'options' => ['attr' => ['class' => 'form-control']],
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Tapez votre mot de passe SVP',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit contenir au moins six caractéres',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('ville',EntityType::class,array(

                'class' => Ville::class,
                'label'    => 'Ville',
                /*'query_builder'=> function (EntityRepository $er)
                {
                    return $er->createQueryBuilder('u')
                        ->where("u.statut = 'oui' ");
                },*/
                'choice_label' =>'libele',
            ))


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
