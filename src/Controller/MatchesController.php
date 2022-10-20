<?php

namespace App\Controller;

use App\Entity\Matches;
use App\Repository\MatchesRepository;
use App\Service\GetMatchesService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MatchesController extends AbstractController
{
    /**
     * @Route("/api/setMatches/{puuid}", name="setMatches")
     */
    public function setMatchesApi($puuid, ManagerRegistry $doctrine, GetMatchesService $getMatches): Response
    {
        //Utilisation du service pour récupérer les donnée du summoner sur l'API RIOT
        $matchesList = $getMatches->getMatches($puuid);

        $matchesEntity = new Matches();
        $matchesEntity->setMatchesList($matchesList);
        $matchesEntity->setSummonerMatchesList($puuid);

        $entityManager = $doctrine->getManager();
        $entityManager->persist($matchesEntity);
        $entityManager->flush();

        return new JsonResponse($matchesList);
    }

    /**
     * @Route("/api/getMatches/{puuid}", name="getMatches", methods={"GET"})
     */
    public function getMatchesApi($puuid, MatchesRepository $matchesRepository): Response
    {
        $matchesList = $matchesRepository->findOneBy(['summonerMatchesList' => $puuid]);
        $dataMatches = ['matchesList' => $matchesList->getMatchesList()];

        return new JsonResponse($dataMatches);
    }
}
