<?php

namespace App\Controller\Back;

use App\Entity\Picture;
use App\Form\Filter\MeansOfPaymentFilterType;
use App\Form\Filter\PictureRepositoryFilterType;
use App\Form\PictureType;
use App\Repository\PictureRepository;
use Knp\Component\Pager\PaginatorInterface;
use Lexik\Bundle\FormFilterBundle\Filter\FilterBuilderUpdaterInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/picture')]
class PictureController extends AbstractController
{
    #[Route('/', name: 'app_admin_picture_index', methods: ['GET'])]
    public function index(
        PictureRepository $pictureRepository,
        PaginatorInterface $paginator,
        FilterBuilderUpdaterInterface $builderUpdater,
        Request $request

    ): Response
    {

        $qb = $pictureRepository->getQbAll();

        $filterForm = $this->createForm(PictureRepositoryFilterType::class, null, [
            'method' => 'GET',
        ]);

        if ($request->query->has($filterForm->getName())) {
            $filterForm->submit($request->query->get($filterForm->getName()));
            $builderUpdater->addFilterConditions($filterForm, $qb);
        }
        $picture = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            10
        );
        return $this->render('back/picture/index.html.twig', [
            'pictures' => $picture,
            'filters' => $filterForm->createView(),

        ]);
    }

    #[Route('/new', name: 'app_back_picture_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PictureRepository $pictureRepository): Response
    {
        $picture = new Picture();
        $form = $this->createForm(PictureType::class, $picture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictureRepository->add($picture, true);

            return $this->redirectToRoute('app_admin_picture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/picture/new.html.twig', [
            'picture' => $picture,
            'form' =>  $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_back_picture_show', methods: ['GET'])]
    public function show(Picture $picture): Response
    {
        return $this->render('back/picture/show.html.twig', [
            'picture' => $picture,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_back_picture_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Picture $picture, PictureRepository $pictureRepository): Response
    {
        $form = $this->createForm(PictureType::class, $picture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pictureRepository->add($picture, true);

            return $this->redirectToRoute('app_admin_picture_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/picture/edit.html.twig', [
            'picture' => $picture,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_back_picture_delete', methods: ['POST'])]
    public function delete(Request $request, Picture $picture, PictureRepository $pictureRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$picture->getId(), $request->request->get('_token'))) {
            $pictureRepository->remove($picture, true);
        }

        return $this->redirectToRoute('app_admin_picture_index', [], Response::HTTP_SEE_OTHER);
    }
}
