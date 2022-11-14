<?php

namespace App\Controller;

use App\Entity\TimelineMatch;
use App\Repository\TimelineMatchRepository;
use App\Service\GetTimelineMatchService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TimelineMatchController extends AbstractController
{
    /**
     * @Route("/api/setTimelineMatch/{matchId}", name="settimelinematch")
     */
    public function setTimelineMatch($matchId, ManagerRegistry $doctrine, GetTimelineMatchService $getTimelineMatchService): Response
    {
        //Utilisation du service pour récupérer les details du match sur l'API RIOT
        $match = $getTimelineMatchService->getTimelineMatch($matchId);
        // recherche de la timeline du match dans la base de donnée :
        $matchInDb = $doctrine->getRepository(TimelineMatch::class)->findOneBy(['matchId' => $matchId]);
        if (!$matchInDb) {
            // mise en BDD des informations récupérer
            $timelineDetail = new TimelineMatch();
            $timelineDetail->setTimelineDetail($match);
            $timelineDetail->setMatchId($matchId);

            $em = $doctrine->getManager();
            $em->persist($timelineDetail);
            $em->flush();
        } else {
            // mise à jour des informations si le match existe déjà
            $matchInDb->setTimelineDetail($match);

            $em = $doctrine->getManager();
            $em->persist($matchInDb);
            $em->flush();
        }

        return new JsonResponse($match);
    }

    /**
     * @Route("/api/getTimelineMatch/{matchId}", name="gettimelinematch", methods={"GET"})
     */
    public function getTimelineMatch($matchId, ManagerRegistry $doctrine, GetTimelineMatchService $getTimelineMatchService, TimelineMatchRepository $timelineMatchRepository): JsonResponse
    {
        $data = $timelineMatchRepository->findOneBy(['matchId' => $matchId]);
        
        if (!$data) {
            //Utilisation du service pour récupérer les details du match sur l'API RIOT
            $match = $getTimelineMatchService->getTimelineMatch($matchId);
            // mise en BDD des informations récupérer
            $timelineDetail = new TimelineMatch();
            $timelineDetail->setTimelineDetail($match);
            $timelineDetail->setMatchId($matchId);

            $em = $doctrine->getManager();
            $em->persist($timelineDetail);
            $em->flush();

            $data = $doctrine->getRepository(TimelineMatch::class)->findOneBy(['matchId' => $matchId]);
        }

        $dataMatch = [
            'matchId' => $data->getMatchId(),
            'timelineMatch' => $data->getTimelineDetail(),
        ];
        return new JsonResponse($dataMatch);
    }
}
