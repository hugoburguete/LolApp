<?php
namespace LolApplication\Library\RiotGames\Resources;

use Illuminate\Support\Collection;
use LolApplication\Models\Summoner;
use LolApplication\Library\RiotGames\ResourceObjects\League;

class LeagueResource extends RiotGamesResource
{
    /**
     * Retrieves a summoner's league rankings
     *
     * @param mixed $summoner
     * @return Collection
     */
    public function getPositionBySummoner($summoner): Collection
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

        $leagues = collect();
        foreach (json_decode($response) as $pos) {
            $leagues->push(League::fromJson(json_encode($pos)));
        }
        return $leagues;
    }
}
