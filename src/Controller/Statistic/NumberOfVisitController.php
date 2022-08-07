<?php

namespace App\Controller\Statistic;

use App\Repository\NumberVisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;


class NumberOfVisitController extends AbstractController
{

    public function __construct(
        private NumberVisiteRepository $numberVisiteRepository
    )
    {

    }

    public function __invoke(): JsonResponse
    {
        $visits = $this->numberVisiteRepository->getNewVisit();
        return new JsonResponse(json_encode(['data' => $visits]));

    }

}

