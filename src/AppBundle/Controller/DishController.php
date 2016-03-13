<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Cart;
use AppBundle\Entity\Dish;
use AppBundle\Form\CartType;
use AppBundle\Form\DishAddType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

/**
 * Class DishController
 * @Route("/menu/dish")
 */
class DishController extends Controller
{
    /**
     * @Route("/list", name="list_dish")
     */
    public function listAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $dishList = $em->getRepository('AppBundle:Dish')->getDishes();
        $categories = $em->getRepository('AppBundle:DishCategory')->getCategoriesDishes();

        $cart = $em->getRepository("AppBundle:Cart")->findOneBy(array('ip'=>$request->getClientIp()));

        foreach($dishList as $dish) {
            $addToCartForms[$dish->getId()] = $this->createForm(CartType::class, $cart, array('dish' => $dish))
                ->add('Замовити', SubmitType::class)
                ->createView();
        }

        return $this->render('AppBundle:Front:menu.html.twig',
            ['dishList' => $dishList,
            'categories' => $categories,
            'form' => $addToCartForms,
            ]);
    }

    /**
     * @Route("/{slug}", name="show_one_dish")
     */
    public function showOneAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $dish = $em->getRepository('AppBundle:Dish')->getOneDish($slug);

        return $this->render('AppBundle:Front:dish.html.twig', ['dish' => $dish]);
    }
}