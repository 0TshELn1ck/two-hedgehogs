<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StaticPageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'attr' => array(
                    'class'=>'form-control'
                )
            ))
            ->add('route', TextType::class, array(
                'attr' => array(
                    'class'=>'form-control'
                )
            ))
            ->add('text', TextareaType::class, array(
                'attr' => array(
                    'class'=>'form-control',

                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\StaticPage',
            'csrf_protection' => false,
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_static_page_type';
    }
}
