<?php

namespace App\Controller\Statistic;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class NewUsersController extends AbstractController
{
    public function __construct(
        private  UserRepository $userRepository
    )
    {

    }



    public function __invoke(): JsonResponse
    {
        $newUser = $this->userRepository->getNewClient();
        return new JsonResponse(json_encode(['data' => $newUser]));
    }



}
