<?php

namespace App\Controller\Statistic;

use App\Repository\BasketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class NumberOfBasketController extends AbstractController
{

    public function __construct(
      private BasketRepository $basketRepository
    )
    {

    }


    public function __invoke(): JsonResponse
    {
        $baskets = $this->basketRepository->getNumberBasket();
        return new JsonResponse(json_encode(['nombre de paniers ' => $baskets]));
    }

}
