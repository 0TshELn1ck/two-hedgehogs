<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 11:43
 */

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dishesInOrder', CollectionType::class, array(
                'entry_type' => DishInOrderType::class
            ))
            ->add('cookTo', DateTimeType::class, [
                'date_widget' => 'single_text',
                'data'=>new \DateTime(date('Y-m-d H:i:s')),
                'time_widget'=>'single_text',
                'attr'=> array(
                    'class'=>'form-control new_time'
                )])
            ->add('address', TextType::class, [
                'attr'=> array(
                    'placeholder'=>'Введіть адресу',
                    'class'=> 'form-control new_addr'
                )
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'AppBundle\Entity\Order']);
    }
}