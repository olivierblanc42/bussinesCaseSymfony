<?php

namespace App\Controller;

use App\Repository\BasketRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
