<?php

namespace App\Controller\Statistic;


use App\Repository\BasketRepository;
use App\Repository\NumberVisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class BasketNewClientConvertionController extends AbstractController
{
    public function __construct(
        private BasketRepository $basketRepository , private NumberVisiteRepository $numberVisiteRepository
    )
    {

    }


    public function __invoke(): JsonResponse
    {
        $basket = $this->basketRepository->getConvertingBaskets();
        $visit = $this->numberVisiteRepository->getVisitBasket();

       $result = round(($visit[1] / $basket[1]) * 100, 2);


        return new JsonResponse($result);

    }

}
