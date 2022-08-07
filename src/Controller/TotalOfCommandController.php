<?php

namespace App\Controller;

use App\Repository\BasketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TotalOfCommandController extends AbstractController
{

    public function __construct(
       private BasketRepository $basketRepository
    )
    {

    }





    public function __invoke(): JsonResponse
    {
       $command = $this->basketRepository->getTotalcommande();
        return new JsonResponse(json_encode(['data' => $command]));
    }
}
