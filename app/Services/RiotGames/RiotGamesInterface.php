<?php
namespace LolApplication\Services\RiotGames;

use LolApplication\Models\Summoner;

interface RiotGamesInterface
{
    /**
     * Retrieves summoner resource.
     *
     * @param string $summoner
     * @param bool $force
     * @return Summoner
     */
    public function getSummonerByName(string $summoner, bool $force = false): Summoner;
}
