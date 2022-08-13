<?php

namespace App\Controller\Statistic;

use App\Repository\BasketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class BasketCanceledController extends AbstractController
{

    public function __construct(
        private BasketRepository $basketRepository
    )
    {

    }

    public function __invoke(): JsonResponse
    {

        $baskets = $this->basketRepository->getBasketCanceled();
        return new JsonResponse( $baskets);
    }



}
