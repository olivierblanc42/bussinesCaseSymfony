<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/front/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_front_user')]
    public function index(): Response
    {
        return $this->render('front/user/index.html.twig', [
            'controller_name' => 'UserAuthenticatorController',
        ]);
    }

    #[Route('/detail', name: 'app_detail_user')]
    public function detail(): Response
    {
        return $this->render('front/user/detailUser.html.twig', [
            'controller_name' => 'UserAuthenticatorController',
        ]);
    }
    #[Route('/order', name: 'app_order_user')]
    public function order(): Response
    {
        return $this->render('front/user/orderUser.html.twig', [
            'controller_name' => 'UserAuthenticatorController',
        ]);
    }
    #[Route('/address', name: 'app_address_user')]
    public function address(): Response
    {
        return $this->render('front/user/addressUser.html.twig', [
            'controller_name' => 'UserAuthenticatorController',
        ]);
    }
}
