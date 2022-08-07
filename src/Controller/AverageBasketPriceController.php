<?php

namespace App\Controller;

use App\Repository\BasketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AverageBasketPriceController extends AbstractController
{

    public function __construct(
        private BasketRepository $basketRepository
    )
    {

    }

    public function __invoke(): JsonResponse
    {
        $sale = $this->basketRepository->getBasketAverageValue();
        return new JsonResponse(json_encode(['data' => $sale]));

    }
}
