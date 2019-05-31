<?php
/**
 * Created by PhpStorm.
 * User: Achraf Zaafrane
 * Date: 27/05/2019
 * Time: 01:55
 */

namespace App\Form;


use App\Entity\Fournisseur;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class FourEditType extends  AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, ['label'=>'Adresse email'])
            ->add('nom',TextType::class,['label'=>'Nom'])
            ->add('prenom',TextType::class,['label'=>'Prénom'])
            ->add('numtel1',TextType::class,['label'=>'Numéro de téléphone 1'])
            ->add('numtel2',null ,array('required'=>false ,'label' => ' Téléphone 2'))
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
                'required' => false,
                'allow_delete' => false,

                'imagine_pattern' => 'test'
            ])
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