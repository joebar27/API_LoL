# API_LoL :
        
        Cette API permet de récupérer des informations sur les détails d'un joueur ou d'un match de League of Legends, pour les exploiter par le biais de la BDD de la meme façon qu'avec l'API RIOT disponible, mais sans limitation de requête.

## Utilisation :

### Pour la premiere utilisation il faut entrer les données a exploitées :

- Pour connaître les détails d'un joueur, il faut utiliser l'URI : `http://127.0.0.1:8001/api/setSummoner/{summonerName}` en lui passant en paramètre le nom du joueur.

- Pour connaître les détails d'un match, il faut utiliser l'URI : `http://127.0.0.1:8000/api/setMatch/{matchId}` en lui passant en paramètre l'identifiant du match.

- Pour récupérer la liste des 20 derniers match du joueur, il faut utiliser l'URI : `http://127.0.0.1:8001/api/setMatches/{puuid}` en lui passant en paramètre le puuid du joueur.

- Pour récupérer la timeline d'un match, il faut utiliser l'URI : `http://127.0.0.1:8001/api/setTimelineMatch/{matchId}` en lui passant en paramètre l'identifiant du match.

### Une fois mis en base de données, vous pouvez récupérer les informations d'un joueur ou d'un match en utilisant les URL suivante :
        
- Pour connaître les détails d'un joueur, il faut utiliser l'URI : `http://127.0.0.1:8001/api/getSummoner/{summonerName}` en lui passant en paramètre le nom du joueur.

- Pour connaître les détails d'un match, il faut utiliser l'URI : `http://127.0.0.1:8000/api/getMatch/{matchId}` en lui passant en paramètre l'identifiant du match.

- Pour récupérer la liste des 20 derniers match du joueur, il faut utiliser l'URI : `http://127.0.0.1:8001/api/getMatches/{puuid}` en lui passant en paramètre le puuid du joueur.

- Pour récupérer la timeline d'un match, il faut utiliser l'URI : `http://127.0.0.1:8001/api/getTimelineMatch/{matchId}` en lui passant en paramètre l'identifiant du match.