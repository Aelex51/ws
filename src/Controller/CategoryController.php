<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

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

    #[Route('/new', name: 'new')]
    public function new(Request $request, CategoryRepository $categoryRepository): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $categoryRepository->save($category, true);

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/new.html.twig', [
            'form' => $form,
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