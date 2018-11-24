<?php
namespace LolApplication\Services\RiotGames;

use LolApplication\Library\RiotGames\ResourceObjects\Summoner;
use LolApplication\Library\RiotGames\Resources\SummonerResource;
use LolApplication\Library\RiotGames\Resources\LeagueResource;

class RiotGamesService implements RiotGamesInterface
{
    /**
     * Riot's Summoner Library Resource
     * @var SummonerResource
     */
    private $summonerResource;

    /**
     * Riot's League Library Resource
     * @var LeagueResource
     */
    private $leagueResource;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->summonerResource = resolve(SummonerResource::class);
        $this->leagueResource = resolve(LeagueResource::class);
    }

    /**
     * {@inheritDoc}
     */
    public function getSummoner(string $summonerName): Summoner
    {
        $summoner = $this->summonerResource
            ->getSummoner($summonerName);
        $positions = $this->leagueResource
            ->getPositionBySummoner($summoner);
        $summoner->addPositions($positions);

        return $summoner;
    }
}
