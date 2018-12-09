<?php
namespace LolApplication\Models;

use LolApplication\Library\RiotGames\ResourceObjects\BaseObject;
use LolApplication\Library\RiotGames\ResourceObjects\Summoner as SummonerResourceObject;
use LolApplication\Models\BaseModel;
use LolApplication\Models\League;
use LolApplication\Models\Match;

class Summoner extends BaseModel
{
    /**
     * Property casts
     * @var array
     */
    protected $casts = [
        'id' => 'string'
    ];

    public $incrementing = false;

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
     * Leagues relationship
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function matches()
    {
        return $this->hasMany(Match::class, 'account_id', 'account_id');
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
