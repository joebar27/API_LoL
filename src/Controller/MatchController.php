<?php

namespace App\Controller;

use App\Entity\MatchDetail;
use App\Repository\MatchDetailRepository;
use App\Service\GetMatchDetailService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MatchController extends AbstractController
{
    /**
     * @Route("/api/setmatchdetail/{matchId}", name="setmatchdetail")
     */
    public function setMatchDetail($matchId, ManagerRegistry $doctrine, GetMatchDetailService $getMatchDetailService): Response
    {
        //Utilisation du service pour récupérer les details du match sur l'API RIOT
        $match = $getMatchDetailService->getMatchDetail($matchId);
        // recherche du détail d'un match dans la base de donnée :
        $matchInDb = $doctrine->getRepository(MatchDetail::class)->findOneBy(['matchId' => $matchId]);
        if (!$matchInDb) {
            // mise en BDD des informations récupérer
            $matchDetail = new MatchDetail();
            $matchDetail->setMatchDetail($match);
            $matchDetail->setMatchId($matchId);

            $em = $doctrine->getManager();
            $em->persist($matchDetail);
            $em->flush();
        } else {
            // mise à jour des informations si le match existe déjà
            $matchInDb->setMatchDetail($match);

            $em = $doctrine->getManager();
            $em->persist($matchInDb);
            $em->flush();
        }

        return new JsonResponse($match);
    }

    /**
     * @Route("/api/getmatchdetail/{matchId}", name="getmatch", methods={"GET"})
     */
    public function getMatch($matchId, MatchDetailRepository $matchDetailRepository): JsonResponse
    {
        $data = $matchDetailRepository->findOneBy(['matchId' => $matchId]);
        $dataMatch = [
            'matchId' => $data->getMatchId(),
            'matchesList' => $data->getMatchDetail(),
        ];
        return new JsonResponse($dataMatch);
    }
}
/* des function a utilisé avec react mais pas pour l'api symfony :
          // ######################################################################################################
          // Récupération des équipes du match
          // ######################################################################################################
          // function getTeams($match)
          // {
          //     foreach ($match['info']['participants'] as $participant) {
          //         if ($participant['teamId'] == 100) {
          //             $team100[] =
          //                 ['summonerName' => $participant['summonerName'],
          //                 'championName' => $participant['championName'],]
          //             ;
          //         } else {
          //             $team200[] = [
          //                 'summonerName' => $participant['summonerName'],
          //                 'championName' => $participant['championName'],
          //             ];
          //         }
          //     }
          //     $teams = [$team100, $team200];
          //     return $teams;
          // }
          // $teams = getTeams($match);


          // ######################################################################################################
          // Récupération des data concernant le summoner observateur
          // ######################################################################################################
          // function getDataSummoner($match)
          // {
          //     foreach ($match['info']['participants'] as $participant) {
          //         if ($participant['summonerName'] == 'Serkuos') {
          //             $data = [
          //                 'gameId' => $match['info']['gameId'],
          //                 'summonerId' => $participant['summonerId'],
          //                 'championName' => $participant['championName'],
          //                 'championLevel' => $participant['champLevel'],
          //                 'kills' => $participant['kills'],
          //                 'deaths' => $participant['deaths'],
          //                 'assists' => $participant['assists'],
          //                 'spells' => [
          //                     'summoner1Id' => $participant['summoner1Id'],
          //                     'summoner2Id' => $participant['summoner2Id'],
          //                 ],
          //                 'items' => [
          //                     'item0' => $participant['item0'],
          //                     'item1' => $participant['item1'],
          //                     'item2' => $participant['item2'],
          //                     'item3' => $participant['item3'],
          //                     'item4' => $participant['item4'],
          //                     'item5' => $participant['item5'],
          //                     'item6' => $participant['item6'],
          //                 ],
          //                 'win' => $participant['win'],
          //                 ];
          //         }
          //     }
          //     // dump($data);
          //     return $data;
          // }
          // $dataSummoner = getDataSummoner($match);

          // dump($dataSummoner['summonerId']);

          // ######################################################################################################
          // mise en BDD des informations récupérer
          // ######################################################################################################

          // $matchDetail = new MatchDetail();
          // $matchDetail->setDateMatch(new \DateTime(strtotime($match['info']['gameCreation'])));
          // $matchDetail->setGameDuration($match['info']['gameDuration']);

          // $matchDetail->setGameId($dataSummoner['gameId']);
          // $matchDetail->setSummonerId($dataSummoner['summonerId']);
          // $matchDetail->setGameWin($dataSummoner['win']);
          // $matchDetail->setChampionName($dataSummoner['championName']);
          // $matchDetail->setChampionLevel($dataSummoner['championLevel']);
          // $matchDetail->setKills($dataSummoner['kills']);
          // $matchDetail->setDeaths($dataSummoner['deaths']);
          // $matchDetail->setAssists($dataSummoner['assists']);
          // $matchDetail->setSummonerSpells($dataSummoner['spells']);
          // $matchDetail->setSummoner1Id($dataSummoner['spells']['summoner1Id']);
          // $matchDetail->setSummoner2Id($dataSummoner['spells']['summoner2Id']);
          // $matchDetail->setItemsListOfSummoner($dataSummoner['items']);

          // $matchDetail->setTeams($teams);

          // $em = $doctrine->getManager();
          // $em->persist($matchDetail);
          // $em->flush();

          return new JsonResponse($match);
          // return new JsonResponse($match);

          public function getMatch($gameId, MatchDetailRepository $matchDetailRepository): JsonResponse
           {
          $data = $matchDetailRepository->findOneBy(['setSummonerNameList' => $gameId]);
          $dataMatch = [
          'setSummonerNameList' => $data->getGameId(),
          'matchesList' => $data->getSummonerId(),
          'championName' => $data->getChampionName(),
          'championLevel' => $data->getChampionLevel(),
          'kills' => $data->getKills(),
          'deaths' => $data->getDeaths(),
          'assists' => $data->getAssists(),
          'spells' => [
              'summoner1Id' => $data->getSummoner1Id(),
              'summoner2Id' => $data->getSummoner2Id(),
          ],
          'items' => [
              'item0' => $data->getItemsListOfSummoner()['item0'],
              'item1' => $data->getItemsListOfSummoner()['item1'],
              'item2' => $data->getItemsListOfSummoner()['item2'],
              'item3' => $data->getItemsListOfSummoner()['item3'],
              'item4' => $data->getItemsListOfSummoner()['item4'],
              'item5' => $data->getItemsListOfSummoner()['item5'],
              'item6' => $data->getItemsListOfSummoner()['item6'],
          ],
          'win' => $data->getGameWin(),
          'dateMatch' => $data->getDateMatch(),
          'gameDuration' => $data->getGameDuration(),
          'teams' => $data->getTeams(),
          'summonerSpells' => $data->getSummonerSpells(),
      ];
      return new JsonResponse($dataMatch);
  }
      */
