<?php
namespace LolApplication\Library\RiotGames\Resources;

use LolApplication\Library\RiotGames\ResourceObjects\Summoner;
use LolApplication\Library\RiotGames\ResourceObjects\Position;

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
            $summonerId = $summoner->id;
        }

        $path = $this->getApiEndpoint([
            'service' => 'league',
            'resource' => 'positions/by-summoner/' . $summonerId,
        ]);
        $response = $this->makeApiCall('GET', $path);

        $positions = [];
        foreach (json_decode($response) as $pos) {
            $positions[] = Position::fromJson(json_encode($pos));
        }
        return $positions;
    }
}
