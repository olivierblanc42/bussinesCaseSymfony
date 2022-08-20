<?php

namespace App\Controller\Front;

use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
#[Route('/front/product')]
class ProductController extends AbstractController
{
    #[Route('/', name: 'app_front_product')]
    public function index(
        ProductRepository $productRepository,
        PaginatorInterface $paginator,
        FilterBuilderUpdaterInterface $builderUpdater,
        Request $request
    ): Response
    {
        $qb = $productRepository->getQbAll();
        $product = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            9
        );

        return $this->render('front/product/index.html.twig', [
            'products' => $product,
        ]);
    }


    #[Route('/best', name: 'user_best_product')]
    public function Best(
        ProductRepository $productRepository,
        PaginatorInterface $paginator,
        FilterBuilderUpdaterInterface $builderUpdater,
        Request $request
    ): Response
    {
        $qb = $productRepository->getBestReview();
        $product = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            9
        );
         dump($product);
        return $this->render('front/product/best.html.twig', [
            'products' => $product,
        ]);
    }

}
