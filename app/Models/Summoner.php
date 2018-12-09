<?php
namespace LolApplication\Models;

use LolApplication\Library\RiotGames\ResourceObjects\BaseObject;
use LolApplication\Library\RiotGames\ResourceObjects\Summoner as SummonerResourceObject;
use LolApplication\Models\BaseModel;
use LolApplication\Models\League;

class Summoner extends BaseModel
{
    /**
     * Property casts
     * @var array
     */
    protected $casts = [
        'id' => 'string'
    ];

    /**
     * Hidden properties
     * @var array
     */
    protected $hidden = [
        'id',
        'account_id',
        'puuid',
        'created_at',
        'updated_at',
    ];

    /**
     * Leagues relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function leagues()
    {
        return $this->hasMany(League::class, 'summoner_id', 'id');
    }

    /**
     * {@inheritDoc}
     */
    protected static function getResourceMap(): array 
    {
        return [
            'id' => 'id',
            'accountId' => 'account_id',
            'puuid' => 'puuid',
            'name' => 'name',
            'profileIconId' => 'profile_icon_id',
            'summonerLevel' => 'level',
        ];
    }
}
