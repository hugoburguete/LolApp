<?php
namespace LolApplication\Services\RiotGames;

use LolApplication\Library\RiotGames\ResourceObjects\Summoner;
use LolApplication\Library\RiotGames\Resources\SummonerResource;
use LolApplication\Library\RiotGames\Resources\LeagueResource;

class RiotGamesService implements RiotGamesInterface
{
    /**
     * Constructor
     */
    public function __construct()
    {

    }

    /**
     * {@inheritDoc}
     */
    public function getSummoner(string $summonerName): Summoner
    {
        $summoner = resolve(SummonerResource::class)
            ->getSummoner($summonerName);
        $positions = resolve(LeagueResource::class)
            ->getPositionBySummoner($summoner);
        $summoner->addPositions($positions);

        return $summoner;
    }
}
