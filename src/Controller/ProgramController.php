<?php
// src/Controller/ProgramController.php
namespace App\Controller;

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

    #[Route('/program/{id<^[0-9]+$>}',methods: ['GET'], name:'program_listById')]
    public function show(int $id, ProgramRepository $programRepository): Response
    {
        $program = $programRepository->findOneBy(['id'=>$id]);

        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : '.$id.' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', ['program' => $program]);
    }

    #[Route('/program/{programId}/seasons/{seasonId}',methods: ['GET'], name:'season_show')]
    public function showSeason(int $programId, int $seasonId, ProgramRepository $programRepository, SeasonRepository $seasonRepository)
    {
        $program = $programRepository->findOneBy(['id'=>$programId]);

        $season = $seasonRepository->findOneBy(['id'=>$seasonId]);
        
        return $this->render('program/season_show.html.twig', 
        ['program' => $program,
        'season' => $season]);
    }
}
