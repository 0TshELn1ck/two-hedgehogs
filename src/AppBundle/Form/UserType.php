<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     *
     * After add new field in UserType need create
     * offsetUnset() method from this field in Security controller
     */
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
            ->add('username', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Логін',
                    'class' => 'form-control'
                ),
                'label' => false
            ))
            ->add('enabled', CheckboxType::class, array(
                'attr' => array(
                'class' => 'ace ace-switch ace-switch-5'
                ),
                'label' => false,
                'required' => false
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
                    'required' => false
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
