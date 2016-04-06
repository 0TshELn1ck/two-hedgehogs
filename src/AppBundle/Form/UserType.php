<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
                    'placeholder' => 'Поштова адреса',
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
            ->add('roles', CollectionType::class, array(
                'allow_delete' => true,
                'entry_type' => ChoiceType::class,
                'entry_options' => array(
                    'choices' => array(
                        'ROLE_USER' => 'Користувач',
                        'ROLE_ADMIN' => 'Адміністратор',
                        'ROLE_COOK' => 'Повар',
                        'ROLE_CARRIER' => 'Кур\'єр',
                    ),
                    'label' => false,
                )))
            ->add('facebook_id', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Facebook ID',
                    'class' => 'form-control'
                ),
                'label' => false,
                'required' => false
            ))
            ->add('google_id', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Google+ ID',
                    'class' => 'form-control'
                ),
                'label' => false,
                'required' => false
            ))
            ->add('enabled', CheckboxType::class, array(
                'attr' => array(
                    'class' => 'ace ace-switch ace-switch-5'
                ),
                'label' => false,
                'required' => false
            ))
            ->add('locked', CheckboxType::class, array(
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
