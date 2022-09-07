<?php

namespace App\Controller\Front;

use App\Entity\NumberVisite;
use App\Repository\ProductRepository;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
    )
    {

    }


    #[Route('/', name: 'app_home')]
    public function index(
        ProductRepository $productRepository,
        ReviewRepository $reviewRepository
    ): Response
    {
        $patreon = New NumberVisite();
        $patreon->setVisitAt(New \DateTime() );
        $this->entityManager->persist($patreon);
        $this->entityManager->flush();





        return $this->render('Front/home/index.html.twig', [
            'controller_name' => 'HomeController',
            'products'=> $productRepository->findBy([], ['label' => 'DESC'], 3),
            'review'=> $reviewRepository->findBy([],['note'=>'DESC'],3)
        ]);
    }

//    #[Route('/space', name: 'app_home')]
//    public function space(): Response
//    {
//
//
//
//        return $this->render('Front/home/space.html.twig', [
//            'controller_name' => 'HomeController',
//
//        ]);
//    }
//
//    #[Route('/contact', name: 'app_home')]
//    public function contact(): Response
//    {
//
//
//
//        return $this->render('/Front/home/contactForm.html.twig', [
//            'controller_name' => 'HomeController',
//
//        ]);
//    }

}
