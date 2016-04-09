<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 15:25
 */

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DishInOrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dish', EntityType::class, array(
                'class'=>'AppBundle\Entity\Dish',
                'choice_label' => 'name',
                'label'=>'',
                'attr'=>array(
                    'class'=>'f_hidden form-control'
                )
            ))
            ->add('count', IntegerType::class, array(
                'label'=>'',
                'scale'=>0,
                'attr'=>array(
                    'class'=>'form-control count_input',
                    'min'=>'1',
                    'max'=>'20'
                )
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\DishInOrder'
        ]);
    }
}