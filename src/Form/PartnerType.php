<?php

namespace App\Form;

use App\Entity\Partner;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PartnerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class,array(
                'attr' => array(
                    'placeholder' => 'Entrer un nom'
                ),
                'label' => 'nom:'))
            ->add('images', FileType::class,[
                'attr' => array(
                    'placeholder' => 'Choisir une image'
                ),
                'label' => 'photos:',
                'multiple' => false,
                'mapped' => false,
                'required' => false
            ])
            ->add('content', TextareaType::class,array(
                'attr' => array(
                    'placeholder' => 'Entrer une description'
                ),
                'label' => 'description:'))
            ->add('phone', TelType::class,array(
                'attr' => array(
                    'placeholder' => 'Entrer un numéro de téléphone'
                ),
                'label' => 'téléphone:'))
            ->add('link', UrlType::class,array(
                'attr' => array(
                    'placeholder' => 'Entrer une adresse web'
                ),
                'label' => 'lien:',
                'required' => false))
            ->add('activityOne', TextType::class,array(
                'attr' => array(
                    'placeholder' => 'Entrer une activité'
                ),
                'label' => 'activité 1:',
                'required' => false))
            ->add('activityTwo', TextType::class,array(
                'attr' => array(
                    'placeholder' => 'Entrer une activité'
                ),
                'label' => 'activité 2:',
                'required' => false))
            ->add('activityThree', TextType::class,array(
                'attr' => array(
                    'placeholder' => 'Entrer une activité'
                ),
                'label' => 'activité 3:',
                'required' => false))
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Partner::class,
        ]);
    }
}
