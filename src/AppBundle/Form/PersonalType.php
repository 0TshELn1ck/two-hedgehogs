<?php

namespace AppBundle\Form;

use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, array(
                'attr' => array(
                    'placeholder' => 'Почтова адреса'
                ),
                'label' => false
            ))
            ->add('name', TextType::class, array(
                'attr' => array(
                    'placeholder' => 'Ім\'я'
                ),
                'label' => false,
                'required' => false
            ))
            ->add('password', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'first_options' => array(
                        'attr' => array(
                            'placeholder' => 'Пароль'
                        ),
                        'label' => false
                    ),
                    'second_options' => array(
                        'attr' => array(
                            'placeholder' => 'Повторіть пароль'
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
            'data_class' => 'AppBundle\Entity\Personal'
        ));
    }

    public function getName()
    {
        return 'app_bundle_personal_type';
    }
}
