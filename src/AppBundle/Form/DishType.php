<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
                'attr' => ['size' => '68', 'placeholder' => 'Назва'],
                'label' => false
            ])
            ->add('recipe', TextareaType::class, [
                'attr' => ['cols' => '68', 'rows' => '10', 'placeholder' => 'рецепт'],
                'label' => false
            ])
            ->add('ingredients', TextareaType::class, [
                'attr' => ['cols' => '68', 'rows' => '5', 'placeholder' => 'інгрідієнти'],
                'label' => false
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'active' => true,
                    'no active' => false
                ],
                'choices_as_values' => true,
                'label' => false
            ])
            ->add('price', IntegerType::class, ['attr' => ['placeholder' => '0'],'label' => false])
            ->add('categories', EntityType::class, [
                'class' => 'AppBundle\Entity\DishCategory',
                'property' => 'name',
                'attr' => [
                    'class' => 'chosen form-control', 'data-placeholder' => '-- виберіть категорію --'
                ],
                'multiple' => 'true', 'label' => false
            ])
            ->add('uploadPictures', CollectionType::class, [
                'required' => false,
                'allow_add' => true,
                'entry_type' => UploadPictureType::class,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'AppBundle\Entity\Dish']);
    }
}
