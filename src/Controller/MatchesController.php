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
        // recherche de la liste de match dans la base de donnée :
        $matchesInDb = $doctrine->getRepository(Matches::class)->findOneBy(['summonerMatchesList' => $puuid]);
        if (!$matchesInDb) {
            // mise en BDD des informations récupérer si la liste de match n'existe pas :
            $matchesEntity = new Matches();
            $matchesEntity->setMatchesList($matchesList);
            $matchesEntity->setPuuid($puuid);

            $entityManager = $doctrine->getManager();
            $entityManager->persist($matchesEntity);
            $entityManager->flush();
        } else {
            // mise à jour des informations si la liste du match existe déjà :
            $matchesInDb->setMatchesList($matchesList);
            
            $em = $doctrine->getManager();
            $em->persist($matchesInDb);
            $em->flush();
        }



        return new JsonResponse($matchesList);
    }

    /**
     * @Route("/api/getMatches/{puuid}", name="getMatches", methods={"GET"})
     */
    public function getMatchesApi($puuid, MatchesRepository $matchesRepository): Response
    {
        $matchesList = $matchesRepository->findOneBy(['puuid' => $puuid]);
        $dataMatches = ['matchesList' => $matchesList->getMatchesList()];

        return new JsonResponse($dataMatches);
    }
}
