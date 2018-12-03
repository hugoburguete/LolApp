<?php
namespace LolApplication\Models;

use LolApplication\Library\RiotGames\ResourceObjects\BaseObject;
use LolApplication\Library\RiotGames\ResourceObjects\Summoner as SummonerResourceObject;
use LolApplication\Models\BaseModel;
use LolApplication\Models\League;

class Summoner extends BaseModel
{
    public function leagues()
    {
        return $this->hasMany(League::class, 'summonerExternalId', 'externalId');
    }

    /**
     * {@inheritDoc}
     */
    protected static function getResourceMap(): array 
    {
        return [
            'id' => 'id',
            'accountId' => 'accountId',
            'puuid' => 'puuid',
            'name' => 'name',
            'profileIconId' => 'profileIconId',
            'summonerLevel' => 'level',
        ];
    }
}
