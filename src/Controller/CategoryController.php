<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/category', name: 'category_') ]
Class CategoryController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $allCategories = $categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'allCategories' => $allCategories
        ]);
    }

    #[Route('/{categoryName}', name: 'show')]
    public function show(string $categoryName, categoryRepository $categoryRepository, programRepository $programRepository): Response
    {
        $category = $categoryRepository->findBy(['name' => $categoryName]);

        if (!$category){
            throw $this->createNotFoundException("Il n'y a pas de catégorie portant ce nom");
        }
        $programsByCategory = $programRepository->findBy(['category' => $category], ['title' => 'DESC'], 3);

        if(!$programsByCategory){
            throw $this->createNotFoundException("Aucune série trouvée");
        }

        return $this->render('category/show.html.twig', [
            'programsByCategory' => $programsByCategory
        ]);
    }
}