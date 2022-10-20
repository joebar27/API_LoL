<?php

namespace App\Controller;

use App\Entity\Summoners;
use App\Repository\SummonersRepository;
use App\Service\GetSummonerService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SummonerController extends AbstractController
{
    /**
     * @Route("/api/setSummoner/{summonerName}", name="setSummoner")
     */
    public function setSummonerApi($summonerName, ManagerRegistry $doctrine, GetSummonerService $getSummoner): JsonResponse
    {
        //Utilisation du service pour récupérer les donnée du summoner sur l'API RIOT
        $summoner = $getSummoner->getSummoner($summonerName);
        // mise en BDD des informations récupérer
        $summonerEntity = new Summoners();
        $summonerEntity->setSummonnersDetail($summoner);
        $summonerEntity->setSummonerName($summonerName);
        $em = $doctrine->getManager();        
        $em->persist($summonerEntity);
        $em->flush();

        return new JsonResponse($summoner) ;
    }

    /**
     * @Route("/api/getSummoner/{summonerName}", name="getSummoner", methods={"GET"})
     */
    public function getSummonerBdd($summonerName,SummonersRepository $summonersRepository): JsonResponse
    {
        $summoners = $summonersRepository->findOneBy(['summonerName' => $summonerName]);
        
        $dataSummoner = [
            'summonnersDetail' => $summoners->getSummonnersDetail(),
        ];

        return new JsonResponse($dataSummoner);
    }
}
