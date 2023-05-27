<?php
// src/Controller/ProgramController.php
namespace App\Controller;

use App\Entity\Program;
use App\Entity\Season;
use App\Entity\Episode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\ProgramType;


#[Route('/', name: 'program_')]
class ProgramController extends AbstractController
{
    #[Route('/programs/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
         $programs = $programRepository->findAll();

         return $this->render(
             'program/index.html.twig',
             ['programs' => $programs,]
         );
    }

    /**
 * The controller for the category add form
 * Display the form or deal with it
 */
#[Route('program/new', name: 'new')]
public function new(Request $request, ProgramRepository $programRepository) : Response
{
    // Create a new Category Object
    $program = new Program();
    // Create the associated Form
    $form = $this->createForm(ProgramType::class, $program);
    // Get data from HTTP request
    $form->handleRequest($request);
    // Was the form submitted ?
    if ($form->isSubmitted()) {
        $programRepository->save($program, true);  
        // Deal with the submitted data
        // For example : persiste & flush the entity
        // And redirect to a route that display the result
    }

    // Render the form
    return $this->render('program/new.html.twig', [
        'form' => $form,
    ]);
}

    #[Route('/program/{id<^[0-9]+$>}',methods: ['GET'], name:'program_show')]
    public function show(Program $program): Response
    {
        if (!$program) {
            throw $this->createNotFoundException(
                'No program found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', ['program' => $program]);
    }

    #[Route('/program/{program}/season/{season}',methods: ['GET'], name:'season_show')]
    public function showSeason(Program $program, Season $season)
    {
        return $this->render('program/season_show.html.twig', 
        ['program' => $program,
        'season' => $season]);
    }

    #[Route('/program/{program}/season/{season}/episode/{episode}',methods: ['GET'], name:'episode_show')]
    public function showEpisode(Program $program, Season $season, Episode $episode)
    {
        return $this->render('program/episode_show.html.twig', 
        ['program' => $program,
        'season' => $season,
        'episode' => $episode]);
    }
}
