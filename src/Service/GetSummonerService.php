<?php

namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use function Symfony\Component\DependencyInjection\Loader\Configurator\env;

class GetSummonerService
{
    public function __construct(EntityManagerInterface $entityManager, ParameterBagInterface $params)
    {
        $this->entityManager = $entityManager;
        $this->params = $params;
    }

    public function getSummoner($summonerName)
    {
        $token = $this->parameterGab->get('RIOT_API_KEY');
        
        $urlGetSummoner = 'https://euw1.api.riotgames.com/lol/summoner/v4/summoners/by-name/' . $summonerName;
        $headers = array('Access-Control-Allow-Origin: *',
        'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/105.0.0.0 Safari/537.36',
        'Accept-Language: fr-FR,fr;q=0.9,en-US;q=0.8,en;q=0.7',
        'Accept-Charset: application/x-www-form-urlencoded; charset=UTF-8"',
        'Origin: https://developer.riotgames.com',
        `X-Riot-Token: $token`);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $urlGetSummoner);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }
}
