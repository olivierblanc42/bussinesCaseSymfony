<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class CountUserController extends AbstractController
{


    public function __construct(
       private UserRepository $userRepository
    )
    {

    }


    public function __invoke(): JsonResponse
    {

        $users = $this->userRepository->getNumberOfUser();
        return new JsonResponse(json_encode(['data' => $users]));
    }

    



  
}
