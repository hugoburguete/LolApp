<?php

namespace LolApplication\Models;

use LolApplication\Models\BaseModel;
use LolApplication\Models\Summoner;

class League extends BaseModel
{
    protected $casts = [
        'id' => 'string'
    ];

    public $incrementing = false;

    /**
     * Summoner Eloquent relationship
     *
     * @return \Illuminate\Database\Eloquent\Builder\BelongsTo
     */
    public function summoner()
    {
        return $this->belongsTo(Summoner::class, 'id', 'summonerId');
    }

    /**
     * {@inheritDoc}
     */
    protected static function getResourceMap(): array 
    {
        return [
            'leagueId' => 'id',
            'summonerId' => 'summonerId',
            'queueType' => 'queueType',
            'wins' => 'wins',
            'losses' => 'losses',
            'leagueName' => 'leagueName',
            'tier' => 'tier',
            'rank' => 'rank',
            'leaguePoints' => 'leaguePoints',
        ];
    }
}
