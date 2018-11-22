<?php
namespace LolApplication\Services\RiotGames;

use LolApplication\Library\RiotGames\ResourceObjects\Summoner;

interface RiotGamesInterface
{
    /**
     * Retrieves summoner resource.
     */
    public function getSummoner(string $summoner): Summoner;
}
