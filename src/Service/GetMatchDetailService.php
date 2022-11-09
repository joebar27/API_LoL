<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;

class GetMatchDetailService
{
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getMatchDetail($gameId)
    {
        //A changer tout les 24h par la nouvel clé api :
        // $tokenRiot = env('RIOT_API_KEY');

        $urlGetMatch = 'https://europe.api.riotgames.com/lol/match/v5/matches/' . $gameId;
        $headers = array('Access-Control-Allow-Origin: *',
                    'User-Agent: "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36',
                    'Accept-Language: fr-FR,fr;q=0.9,en-US;q=0.8,en;q=0.7',
                    'Accept-Charset: application/x-www-form-urlencoded; charset=UTF-8',
                    'Origin: https://developer.riotgames.com',
                    'X-Riot-Token: RGAPI-dd0ee5de-b287-4c82-b7e1-656d36b15b1b');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlGetMatch);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }
}
