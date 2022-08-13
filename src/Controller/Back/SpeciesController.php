<?php

namespace App\Controller\Back;

use App\Entity\Species;
use App\Form\Species1Type;
use App\Repository\SpeciesRepository;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/back/species')]
class SpeciesController extends AbstractController
{
    #[Route('/', name: 'app_back_species_index', methods: ['GET'])]
    public function index(
        SpeciesRepository $speciesRepository,
        PaginatorInterface $paginator,
        FilterBuilderUpdaterInterface $builderUpdater,
        Request $request
    ): Response
    {
        $qb = $speciesRepository->getQbAll();
        $species = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );


        return $this->render('back/species/index.html.twig', [
            'species' => $species ,
        ]);
    }

    #[Route('/new', name: 'app_back_species_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SpeciesRepository $speciesRepository): Response
    {
        $species = new Species();
        $form = $this->createForm(Species1Type::class, $species);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $speciesRepository->add($species, true);

            return $this->redirectToRoute('app_back_species_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/species/new.html.twig', [
            'species' => $species,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_species_show', methods: ['GET'])]
    public function show(Species $species): Response
    {
        return $this->render('back/species/show.html.twig', [
            'species' => $species,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_back_species_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Species $species, SpeciesRepository $speciesRepository): Response
    {
        $form = $this->createForm(Species1Type::class, $species);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $speciesRepository->add($species, true);

            return $this->redirectToRoute('app_back_species_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/species/edit.html.twig', [
            'species' => $species,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_species_delete', methods: ['POST'])]
    public function delete(Request $request, Species $species, SpeciesRepository $speciesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$species->getId(), $request->request->get('_token'))) {
            $speciesRepository->remove($species, true);
        }

        return $this->redirectToRoute('app_back_species_index', [], Response::HTTP_SEE_OTHER);
    }
}
