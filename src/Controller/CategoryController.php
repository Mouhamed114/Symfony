<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;

#[Route('/category', name: 'category_')]
class CategoryController extends AbstractController
{
    #[Route('/', name: 'name')]
    public function index(CategoryRepository $categoryRepository): Response
    {
         $categories = $categoryRepository->findAll();

         return $this->render(
             'category/index.html.twig',
             ['categories' => $categories]
         );
    }
    
    #[Route('/{categoryName}', methods: ['GET'], name:'show')]
    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    {
        $category = $categoryRepository->findOneBy(['name'=>$categoryName]);
       
        if (!$category) {
            throw $this->createNotFoundException('The category does not exist');}

        $programs = $programRepository->findBy(
            ['category' => $category->getId()],
            ['id' =>'DESC'],
            3,
            0
        );
        
        return $this->render('category/show.html.twig',
        ['category' => $category,
        'programs' => $programs]
    );
   // return new Response('rien');
    }
}
