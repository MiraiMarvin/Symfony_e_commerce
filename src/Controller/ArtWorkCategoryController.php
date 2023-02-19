<?php

namespace App\Controller;

use App\Entity\ArtWorkCategory;
use App\Form\ArtWorkCategoryType;
use App\Repository\ArtWorkCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/art/work/category')]
class ArtWorkCategoryController extends AbstractController
{
    #[Route('/', name: 'app_art_work_category_index', methods: ['GET'])]
    public function index(ArtWorkCategoryRepository $artWorkCategoryRepository): Response
    {
        return $this->render('art_work_category/index.html.twig', [
            'art_work_categories' => $artWorkCategoryRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_art_work_category_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ArtWorkCategoryRepository $artWorkCategoryRepository): Response
    {
        $artWorkCategory = new ArtWorkCategory();
        $form = $this->createForm(ArtWorkCategoryType::class, $artWorkCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artWorkCategoryRepository->save($artWorkCategory, true);

            return $this->redirectToRoute('app_art_work_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('art_work_category/new.html.twig', [
            'art_work_category' => $artWorkCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_art_work_category_show', methods: ['GET'])]
    public function show(ArtWorkCategory $artWorkCategory): Response
    {
        return $this->render('art_work_category/show.html.twig', [
            'art_work_category' => $artWorkCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_art_work_category_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ArtWorkCategory $artWorkCategory, ArtWorkCategoryRepository $artWorkCategoryRepository): Response
    {
        $form = $this->createForm(ArtWorkCategoryType::class, $artWorkCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artWorkCategoryRepository->save($artWorkCategory, true);

            return $this->redirectToRoute('app_art_work_category_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('art_work_category/edit.html.twig', [
            'art_work_category' => $artWorkCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_art_work_category_delete', methods: ['POST'])]
    public function delete(Request $request, ArtWorkCategory $artWorkCategory, ArtWorkCategoryRepository $artWorkCategoryRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artWorkCategory->getId(), $request->request->get('_token'))) {
            $artWorkCategoryRepository->remove($artWorkCategory, true);
        }

        return $this->redirectToRoute('app_art_work_category_index', [], Response::HTTP_SEE_OTHER);
    }
}
