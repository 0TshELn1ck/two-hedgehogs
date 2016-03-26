<?php
/**
 * Created by PhpStorm.
 * User: den
 * Date: 26.03.16
 * Time: 21:46
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class UserController
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/orders", name="userProfile")
     * @Template("AppBundle:Front:userOrders.html.twig")
     */
    public function profileAction(Request $request)
    {
        $user = $this->getUser();
        
        if ($user){
            return [
                'orders'=>$user->getOrders()
            ];
        }
        
        return $this->redirectToRoute('homepage');
    }
}