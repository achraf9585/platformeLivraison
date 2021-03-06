<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Supplement;
use Doctrine\ORM\EntityRepository;
use function Sodium\add;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bridge\Doctrine\Form\Type\Textty;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user=$options['user'];

        $builder
            ->add('libele')
            ->add('prix')
            ->add('categorie',EntityType::class,array(
                // query choices from this entity
                'class' => 'App:Categorie',

                'multiple'  => false,
                'required' => true,
                'choice_label' => 'libele'))

          ->add('imageFile' , VichImageType::class,[
              'required' => false,
              'allow_delete' => false,

              'imagine_pattern' => 'test'
          ])
           ->add('supplements', EntityType::class,
               ['class'=> Supplement::class,

                 'choice_label'=>'libele',
                   'multiple'=>true,
                   'expanded'=>true,
               ])
            ->add('etatArticle', ChoiceType::class,[
                'choices'=>
                    [
                        'Activé'=>'Activé',
                        'Désactivé'=>'Désactivé'
                    ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
            'user' => null,

        ]);
    }
}
