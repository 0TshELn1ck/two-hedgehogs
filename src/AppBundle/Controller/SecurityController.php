<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Form\UserType;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="user_login")
     * @Template()
     */
    public function loginAction(Request $request)
    {
        $user = new User();
        $form = $this->createFormBuilder($user)
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
            )
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
// ... do any other work - like send them an email, etc
// maybe set a "flash" success message for the user
            return $this->redirectToRoute('user_login');
        }

        $authenticationUtils = $this->get('security.authentication_utils');
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return [
            'registrationForm' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error
        ];
    }
}