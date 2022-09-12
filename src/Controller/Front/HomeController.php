<?php

namespace App\Controller\Front;

use App\Entity\NumberVisite;
use App\Repository\ProductRepository;
use App\Repository\ReviewRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
        ProductRepository  $productRepository,
        Request $request,
        PaginatorInterface $paginator,
    ): Response
    {
        $patreon = new NumberVisite();
        $patreon->setVisitAt(new \DateTime());
        $this->entityManager->persist($patreon);
        $this->entityManager->flush();

        $qb = $productRepository->getQbAll();
        $product = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            9
        );


        return $this->render('Front/home/index.html.twig', [
            'controller_name' => 'HomeController',
            'products' => $product,

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
