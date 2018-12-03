<?php

namespace LolApplication\Models;

use LolApplication\Models\BaseModel;
use LolApplication\Models\Summoner;

class League extends BaseModel
{
    /**
     * Summoner Eloquent relationship
     *
     * @return \Illuminate\Database\Eloquent\Builder\BelongsTo
     */
    public function summoner()
    {
        return $this->belongsTo(Summonner::class, 'externalId', 'summonerExternalId');
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
