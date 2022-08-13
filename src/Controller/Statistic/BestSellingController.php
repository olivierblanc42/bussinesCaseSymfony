<?php

namespace App\Controller\Statistic;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

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
