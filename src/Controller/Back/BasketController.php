<?php

namespace App\Controller\Back;

use App\Entity\Basket;
use App\Form\BasketType;
use App\Form\Filter\BasketFilterType;
use App\Form\Filter\UserFilterType;
use App\Repository\BasketRepository;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/basket')]
class BasketController extends AbstractController
{
    #[Route('/', name: 'app_admin_basket_index', methods: ['GET'])]
    public function index(
        BasketRepository $basketRepository,
        PaginatorInterface $paginator,
        FilterBuilderUpdaterInterface $builderUpdater,
        Request $request
    ): Response
    {


        $qb = $basketRepository->getQbAll();


        $filterForm = $this->createForm(BasketFilterType::class, null, [
            'method' => 'GET',
        ]);

        if ($request->query->has($filterForm->getName())) {
            $filterForm->submit($request->query->get($filterForm->getName()));
            $builderUpdater->addFilterConditions($filterForm, $qb);
        }
        $baskets = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            15
        );
        return $this->render('back/basket/index.html.twig', [
            'baskets' => $baskets,
            'filters' => $filterForm->createView(),

        ]);
    }

    #[Route('/new', name: 'app_back_basket_new', methods: ['GET', 'POST'])]
    public function new(Request $request, BasketRepository $basketRepository): Response
    {
        $basket = new Basket();
        $form = $this->createForm(BasketType::class, $basket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $basketRepository->add($basket, true);

            return $this->redirectToRoute('app_admin_basket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/basket/new.html.twig', [
            'basket' => $basket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_basket_show', methods: ['GET'])]
    public function show(Basket $basket): Response
    {
        return $this->render('back/basket/show.html.twig', [
            'basket' => $basket,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_back_basket_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Basket $basket, BasketRepository $basketRepository): Response
    {
        $form = $this->createForm(BasketType::class, $basket);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $basketRepository->add($basket, true);

            return $this->redirectToRoute('app_back_basket_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/basket/edit.html.twig', [
            'basket' => $basket,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_basket_delete', methods: ['POST'])]
    public function delete(Request $request, Basket $basket, BasketRepository $basketRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$basket->getId(), $request->request->get('_token'))) {
            $basketRepository->remove($basket, true);
        }

        return $this->redirectToRoute('app_back_basket_index', [], Response::HTTP_SEE_OTHER);
    }
}
