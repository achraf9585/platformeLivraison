<?php
/**
 * Created by PhpStorm.
 * User: Achraf Zaafrane
 * Date: 17/06/2019
 * Time: 01:23
 */

namespace App\Form;


use App\Entity\Client;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
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

            ]);


    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }


}