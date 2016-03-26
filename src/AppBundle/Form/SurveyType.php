<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class SurveyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => array('size' => '68')
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'active' => true,
                    'no actice' => false
                ],
                'expanded' => true,
                'multiple' => false,
                'choices_as_values' => true,
            ])
            ->add('answer1', TextType::class, [
                'attr' => array('cols' => '68'), 'mapped' => false, 'label' => false
            ])
            ->add('answer2', TextType::class, [
                'attr' => array('cols' => '68'), 'mapped' => false, 'label' => false
            ])
            ->add('answer3', TextType::class, [
                'attr' => array('cols' => '68'), 'mapped' => false, 'label' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'AppBundle\Entity\Survey']);
    }
}
