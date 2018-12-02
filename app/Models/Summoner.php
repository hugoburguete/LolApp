<?php
namespace LolApplication\Models;

use LolApplication\Library\RiotGames\ResourceObjects\Summoner as SummonerResource;
use LolApplication\Models\BaseModel;

class Summoner extends BaseModel
{
    /**
     * Maps the riot API resource into a workable model
     *
     * @param SummonerResource $resource
     * @return Summoner
     */
    public static function mapFromResource(SummonerResource $resource): Summoner
    {
        $summoner = new self();

    }
}
