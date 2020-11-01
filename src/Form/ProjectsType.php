<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Projects;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,array(
                'attr' => array(
                    'placeholder' => 'Entrer un nom'
                ),
                'label' => 'nom:'))

            ->add('content', TextareaType::class,array(
                'attr' => array(
                    'placeholder' => 'Entrer une description'
                ),
                'label' => 'description:'))
            ->add('images', FileType::class,[
                'attr' => array(
                    'placeholder' => 'Choisir une ou plusieurs photos'
                ),
                'label' => 'photos:',
                'multiple' => true,
                'mapped' => false,
                'required' => false
            ])
            ->add('imgBefore', FileType::class,[
                'attr' => array(
                    'placeholder' => 'Choisir une photo avant'
                ),
                'label' => 'photos avant:',
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('imgAfter', FileType::class,[
                'attr' => array(
                    'placeholder' => 'Choisir une photo après'
                ),
                'label' => 'photos après:',
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('category', EntityType::class,[
                'class' => Category::class,
                'choice_label' => 'name',
                'label' => 'categorie:'
            ])
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Projects::class,
        ]);
    }
}
