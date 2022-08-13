<?php

namespace App\Controller\Statistic;

use App\Repository\BasketRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class AverageBasketAbandonnedController extends AbstractController
{

    public function __construct(
        private BasketRepository $basketRepository
    )
    {

    }

    /**
     * @throws NonUniqueResultException
     */
    public function __invoke(): JsonResponse
    {
        $sale = $this->basketRepository->getBasketPercentageAbandoned();
        return new JsonResponse($sale);

    }



}
