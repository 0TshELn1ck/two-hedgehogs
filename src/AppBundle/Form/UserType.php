<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array(
                'attr' => array(
                    'placeholder' => 'Почтова адреса',
                    'class' => 'form-control'
                ),
                'label' => false
            ))
            ->add('password', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options' => array(
                        'attr' => array(
                            'placeholder' => 'Пароль',
                            'class' => 'form-control'
                        ),
                        'label' => false
                    ),
                    'second_options' => array(
                        'attr' => array(
                            'placeholder' => 'Повторіть пароль',
                            'class' => 'form-control'
                        ),
                        'label' => false
                    ),
                )
            );
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_bundle_user_type';
    }
}
