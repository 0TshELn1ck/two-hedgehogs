<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class DishType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => array('size' => '68')
            ])
            ->add('recipe', TextareaType::class, [
                'attr' => array('cols' => '68', 'rows' => '10')
            ])
            ->add('ingredients', TextareaType::class, [
                'attr' => array('cols' => '68', 'rows' => '5')
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'active' => true,
                    'no active' => false
                ],
                'choices_as_values' => true
            ])
            ->add('price', IntegerType::class)
            ->add('categories', EntityType::class, [
                'class' => 'AppBundle\Entity\DishCategory',
                'choice_label' => 'name',
                'expanded' => 'true',
                'multiple' => 'true'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'AppBundle\Entity\Dish']);
    }
}
