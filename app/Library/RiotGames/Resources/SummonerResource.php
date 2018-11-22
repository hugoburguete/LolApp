<?php
namespace LolApplication\Library\RiotGames\Resources;

use LolApplication\Library\RiotGames\ResourceObjects\Summoner as SummonerObject;

class SummonerResource extends RiotGamesResource
{
    /**
     * {@inheritDoc}
     */
    public function getSummoner(string $summonerName): SummonerObject
    {
        $path = $this->getApiEndpoint([
            'service' => 'summoner',
            'resource' => 'summoners/by-name/' . $summonerName,
        ]);
        $response = $this->makeApiCall('GET', $path);
        return SummonerObject::fromJson($response);
    }
}
