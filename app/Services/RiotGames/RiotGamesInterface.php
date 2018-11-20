<?php
namespace LolApplication\Services\RiotGames;

interface RiotGamesInterface
{
    /**
     * Retrieves summoner.
     */
    public function getSummoner(string $summoner);

    /**
     * Sets the region for this service.
     */
    public function setRegion(string $region): void;
}
