<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BestSellingController extends AbstractController
{

    public function __construct(
        private ProductRepository $productRepository
    )
    {

    }

    public function __invoke(): JsonResponse
    {
        $products = $this->productRepository->getBestProducts();
        return new JsonResponse( (['Best selling' => $products]));

    }


}
