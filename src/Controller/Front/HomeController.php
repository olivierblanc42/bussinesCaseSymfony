<?php

namespace App\Controller\Front;

use App\Entity\NumberVisite;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager
    )
    {

    }


    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        $patreon = New NumberVisite();
        $patreon->setVisitAt(New \DateTime() );
        $this->entityManager->persist($patreon);
        $this->entityManager->flush();

        return $this->render('Front/home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
