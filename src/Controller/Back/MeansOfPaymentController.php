<?php

namespace App\Controller\Back;

use App\Entity\MeansOfPayment;
use App\Form\Filter\CategoryFilterType;
use App\Form\Filter\MeansOfPaymentFilterType;
use App\Form\MeansOfPaymentType;
use App\Repository\MeansOfPaymentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/back/means/of/payment')]
class MeansOfPaymentController extends AbstractController
{
    #[Route('/', name: 'app_back_means_of_payment_index', methods: ['GET'])]
    public function index(
        MeansOfPaymentRepository $meansOfPaymentRepository,
        PaginatorInterface $paginator,
        FilterBuilderUpdaterInterface $builderUpdater,
        Request $request

    ): Response
    {
        $qb = $meansOfPaymentRepository->getQbAll();
        $filterForm = $this->createForm(MeansOfPaymentFilterType::class, null, [
            'method' => 'GET',
        ]);

        if ($request->query->has($filterForm->getName())) {
            $filterForm->submit($request->query->get($filterForm->getName()));
            $builderUpdater->addFilterConditions($filterForm, $qb);
        }
        $meansOfPayment = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            15
        );




        return $this->render('back/means_of_payment/index.html.twig', [
            'means_of_payments' => $meansOfPayment,
            'filters' => $filterForm->createView(),

        ]);
    }

    #[Route('/new', name: 'app_back_means_of_payment_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MeansOfPaymentRepository $meansOfPaymentRepository): Response
    {
        $meansOfPayment = new MeansOfPayment();
        $form = $this->createForm(MeansOfPaymentType::class, $meansOfPayment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $meansOfPaymentRepository->add($meansOfPayment, true);

            return $this->redirectToRoute('app_back_means_of_payment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/means_of_payment/new.html.twig', [
            'means_of_payment' => $meansOfPayment,
            'form' =>$form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_back_means_of_payment_show', methods: ['GET'])]
    public function show(MeansOfPayment $meansOfPayment): Response
    {
        return $this->render('back/means_of_payment/show.html.twig', [
            'means_of_payment' => $meansOfPayment,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_back_means_of_payment_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MeansOfPayment $meansOfPayment, MeansOfPaymentRepository $meansOfPaymentRepository): Response
    {
        $form = $this->createForm(MeansOfPaymentType::class, $meansOfPayment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $meansOfPaymentRepository->add($meansOfPayment, true);

            return $this->redirectToRoute('app_back_means_of_payment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/means_of_payment/edit.html.twig', [
            'means_of_payment' => $meansOfPayment,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_means_of_payment_delete', methods: ['POST'])]
    public function delete(Request $request, MeansOfPayment $meansOfPayment, MeansOfPaymentRepository $meansOfPaymentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$meansOfPayment->getId(), $request->request->get('_token'))) {
            $meansOfPaymentRepository->remove($meansOfPayment, true);
        }

        return $this->redirectToRoute('app_back_means_of_payment_index', [], Response::HTTP_SEE_OTHER);
    }
}
