<?php
namespace LolApplication\Library\RiotGames\Resources;

use LolApplication\Models\Summoner;
use LolApplication\Library\RiotGames\ResourceObjects\League;

class LeagueResource extends RiotGamesResource
{
    /**
     * Retrieves a summoner's league rankings
     *
     * @param mixed $summoner
     * @return array
     */
    public function getPositionBySummoner($summoner): array
    {
        $summonerId = 0;
        if (is_int($summoner)) {
            $summonerId = $summoner;
        } else if ($summoner instanceof Summoner) {
            $summonerId = $summoner->externalId;
        }

        $path = $this->getApiEndpoint([
            'service' => 'league',
            'resource' => 'positions/by-summoner/' . $summonerId,
        ]);
        $response = $this->makeApiCall('GET', $path);

        $leagues = [];
        foreach (json_decode($response) as $pos) {
            $leagues[] = League::fromJson(json_encode($pos));
        }
        return $leagues;
    }
}
