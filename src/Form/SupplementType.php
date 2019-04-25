<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Supplement;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SupplementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('libele')
            ->add('prix')
            ->add('articles', EntityType::class,[
                'class'=> Article::class,
                'choice_label'=>'libele',
                'multiple'=>true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Supplement::class,
        ]);
    }
}
