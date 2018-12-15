<?php
namespace LolApplication\Library\RiotGames\Resources;

use LolApplication\Library\RiotGames\ResourceObjects\Summoner as SummonerObject;

class SummonerResource extends RiotGamesResource
{
    /**
     * Retrieves a summoner from Riot's API
     *
     * @param string $summonerName The name of the summoner to retrieve
     * @return SummonerObject An object representation of the summoner.
     * @throws HttpRequestException Http request has failed
     */
    public function getSummonerByName(string $summonerName): SummonerObject
    {
        $path = $this->getRequestEndpoint([
            'service' => 'summoner',
            'resource' => 'summoners/by-name/' . $summonerName,
        ]);
        $response = $this->makeRequest('GET', $path);
        return SummonerObject::fromJson($response);
    }

    /**
     * Retrieves a summoner from Riot's API
     *
     * @param string $summonerId The id of the summoner to retrieve
     * @return SummonerObject An object representation of the summoner.
     * @throws HttpRequestException Http request has failed
     */
    public function getSummonerById(string $summonerId): SummonerObject
    {
        $path = $this->getRequestEndpoint([
            'service' => 'summoner',
            'resource' => 'summoners/' . $summonerId,
        ]);
        $response = $this->makeRequest('GET', $path);
        return SummonerObject::fromJson($response);
    }

    /**
     * {@inhericDoc}
     */
    public function getRequestExceptionMessage(): string
    {
        return 'Error retrieving summoner';
    }
}
