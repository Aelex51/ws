<?php

namespace App\Controller;

use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use App\Repository\EpisodeRepository;
use App\Repository\SeasonRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function PHPUnit\Framework\throwException;
use Symfony\Component\HttpFoundation\Request;

#[Route('/program', name: 'program_')]
Class ProgramController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(ProgramRepository $programRepository): Response
    {
        $allPrograms = $programRepository->findAll();

        return $this->render('program/index.html.twig', [
            'allPrograms' => $allPrograms
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, ProgramRepository $programRepository): Response
    {
        $program = new Program();

        $form = $this->createForm(ProgramType::class, $program);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            $programRepository->save($program, true);

            return $this->redirectToRoute('program_index');
        }

        return $this->render('program/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'], methods: ['GET'])]
    public function show(Program $program): Response
    {
        if (!$program) {
            throw $this->createNotFoundException(
                'No program with id : ' . $id . ' found in program\'s table.'
            );
        }
        return $this->render('program/show.html.twig', [
            'program' => $program
        ]);
    }

    #[Route('/{programId}/seasons/{seasonId}', name: 'season_show')]
    public function showSeason(Program $programId, Season $seasonId): Response
    {
        return $this->render('program/season_show.html.twig', [
            'program' => $programId,
            'season' => $seasonId,
        ]);
    }

    #[Route('/{programId}/season/{seasonId}/episode/{episodeId}', name: 'episode_show')]
    public function showEpisode(Program $programId, Season $seasonId, Episode $episodeId): Response
    {
        return $this->render('program/episode_show.html.twig', [
            'program' => $programId,
            'season' => $seasonId,
            'episode' => $episodeId,
        ]);
    }
}