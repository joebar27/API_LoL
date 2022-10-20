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

        $timelineDetail = new TimelineMatch();
        $timelineDetail->setTimelineDetail($match);
        $timelineDetail->setMatchId($matchId);

        $em = $doctrine->getManager();
        $em->persist($timelineDetail);
        $em->flush();

        return new JsonResponse($match);
    }

    /**
     * @Route("/api/getTimelineMatch/{matchId}", name="gettimelinematch", methods={"GET"})
     */
    public function getTimelineMatch($matchId, TimelineMatchRepository $timelineMatchRepository): JsonResponse
    {
        $data = $timelineMatchRepository->findOneBy(['matchId' => $matchId]);
        $dataMatch = [
            'matchId' => $data->getMatchId(),
            'timelineMatch' => $data->getTimelineDetail(),
        ];
        return new JsonResponse($dataMatch);
    }
}
