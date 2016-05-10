<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SurveyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'attr' => ['size' => '68'], 'label' => false
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'active' => true,
                    'no active' => false
                ],
                'choices_as_values' => true, 'label' => false
            ])
            ->add('answer0', TextType::class, [
                'attr' => ['class' => 'last','cols' => '68'],
                'mapped' => false, 'label' => false, 'required' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'AppBundle\Entity\Survey', 'allow_extra_fields' => true]);
    }
}
