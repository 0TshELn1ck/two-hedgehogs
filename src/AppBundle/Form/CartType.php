<?php

namespace AppBundle\Form;

use Doctrine\DBAL\Types\ObjectType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('dishes', EntityType::class, array(
                'class' => 'AppBundle:Dish',
                'choice_label' => 'id',
                'choices' => array($options['dish']),
            ));
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'AppBundle\Entity\Cart',
                                'dish' => 'AppBundle\Entity\Dish']);
    }
}