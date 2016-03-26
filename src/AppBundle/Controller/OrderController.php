<?php
namespace AppBundle\Controller;

use AppBundle\Entity\DishInOrder;

use AppBundle\Form\OrderType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class DishController
 * @Route("/order")
 */
class OrderController extends Controller
{
    /**
     * @Route("/", name="cart")
     * @Template("AppBundle:Front:order.html.twig")
     */
    public function getCartAction(Request $request)
    {
        $user = $this->getUser();

        if ($user){
            $cart = $user->getCart();

                $dish = $cart->getDishes()[0];
                $dishInOrder = new DishInOrder();
                $dishInOrder->setDish($dish);
                $form = $this->createFormBuilder($dishInOrder)
                    ->add('dish', EntityType::class, array(
                        'class' => 'AppBundle:Dish',
                        'choice_label' => 'name',
                        'choices' => array($dishInOrder->getDish()),
                    ))
                    ->add('count', IntegerType::class, array(
                        'scale'=>0,
                        'data' =>1,
                        'attr' => array(
                            'min'=>0,
                            'max'=>20,
                        )
                    ))
                    ->add('order', OrderType::class)
                    ->add('submit', SubmitType::class)
                    ->getForm();


            if ($request->getMethod() === 'POST') {
                $form->handleRequest($request);
                $dishInOrder->getOrder()->setUser($user);
                $em = $this->getDoctrine()->getManager();
                $em->persist($dishInOrder);
                $em->flush();
            }

            return [
                'dishes'=>$cart->getDishes(),
                'cart'=>$cart,
                'form' => $form->createView(),
            ];
        }

        return $this->redirect($this->generateUrl('user_login'));
    }
}