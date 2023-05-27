<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CategoryRepository;
use App\Repository\ProgramRepository;
use App\Form\CategoryType;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;



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

    /**
 * The controller for the category add form
 * Display the form or deal with it
 */
#[Route('/new', name: 'new')]
public function new(Request $request, CategoryRepository $categoryRepository) : Response
{
    // Create a new Category Object
    $category = new Category();
    // Create the associated Form
    $form = $this->createForm(CategoryType::class, $category);
    // Get data from HTTP request
    $form->handleRequest($request);
    // Was the form submitted ?
    if ($form->isSubmitted()) {
        $categoryRepository->save($category, true); 
        // Deal with the submitted data
        // For example : persiste & flush the entity
        // And redirect to a route that display the result
    }

    // Render the form
    return $this->render('category/new.html.twig', [
        'form' => $form,
    ]);
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
