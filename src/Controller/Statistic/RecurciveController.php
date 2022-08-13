<?php

namespace App\Controller\Statistic;

use App\Repository\BasketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class RecurciveController extends AbstractController
{

    public function __construct(
        private BasketRepository $basketRepository
    )
    {

    }


    public function __invoke(): JsonResponse
    {
        $sale = $this->basketRepository->getrecurance();
        return new JsonResponse($sale);

    }



}
