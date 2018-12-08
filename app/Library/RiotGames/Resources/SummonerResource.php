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
        $path = $this->getRequestEndpoint([
            'service' => 'summoner',
            'resource' => 'summoners/bycc-name/' . $summonerName,
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
