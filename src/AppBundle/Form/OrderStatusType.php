<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderStatusType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('status', ChoiceType::class, array(
                'choices' =>array(
                    'processing'  => 'В обробці',
                    'canceled'    => 'Відмовленно',
                    'confirmed'   => 'Очікує приготування',
                    'cooking'     => 'Готується',
                    'cooked'      => 'Приготований',
                    'shipping'    => 'Доставляється',
                    'closed'      => 'Завершений',
                ),
                'attr'=>array('class'=>'form-control'),
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(['data_class' => 'AppBundle\Entity\Order']);
    }
}
