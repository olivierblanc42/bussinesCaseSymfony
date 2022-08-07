<?php

namespace App\Controller;


use App\Repository\BasketRepository;
use App\Repository\NumberVisiteRepository;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BasketConvertionController extends AbstractController
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
