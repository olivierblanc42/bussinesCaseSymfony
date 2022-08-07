<?php

namespace App\Controller;

use App\Entity\Basket;
use App\Entity\CommandStatus;
use App\Entity\QuantityInBasket;
use App\Repository\BasketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class TotalSalesController extends AbstractController
{



    public function __construct(
       private BasketRepository $basketRepository
    )
    {

    }



    public function __invoke(): JsonResponse
    {
        $sale = $this->basketRepository->getSales();
        return new JsonResponse(json_encode(['data' => $sale]));

    }








}
