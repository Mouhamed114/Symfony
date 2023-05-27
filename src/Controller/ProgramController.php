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
