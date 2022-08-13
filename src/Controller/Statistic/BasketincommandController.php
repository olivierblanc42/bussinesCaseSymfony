<?php

namespace App\Controller\Statistic;

use App\Repository\BasketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class BasketincommandController extends AbstractController
{

    public function __construct(
        private BasketRepository $basketRepository
    )
    {

    }

    public function __invoke(): JsonResponse
    {

        $baskets = $this->basketRepository->getBasketPercentagecommand();
        return new JsonResponse(json_encode(['data' => $baskets]));
    }

}
