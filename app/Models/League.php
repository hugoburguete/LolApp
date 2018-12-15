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

    protected $hidden = [
        'summoner_id',
        'id',
        'tier',
        'created_at',
        'updated_at',
    ];

    /**
     * Summoner Eloquent relationship
     *
     * @return \Illuminate\Database\Eloquent\Builder\BelongsTo
     */
    public function summoner()
    {
        return $this->belongsTo(Summonner::class, 'id', 'summoner_id');
    }

    public function getRankAttribute($value)
    {
        return $this->tier . ' ' . $value;
    }

    /**
     * Maps queue type property
     *
     * @param  string $value The queue type
     * @return string        The human readable version of the queue type
     */
    public function getQueueTypeAttribute($value)
    {
        switch ($value) {
            case 'RANKED_SOLO_5x5':
                return 'Ranked Solo/Duo';
                break;
            case 'RANKED_FLEX_TT':
                return 'Ranked Flex 3v3';
                break;
            case 'RANKED_FLEX_SR':
                return 'Ranked Flex 5v5';
                break;
            default:
                return $value;
                break;
        }
    }

    /**
     * {@inheritDoc}
     */
    protected static function getResourceMap(): array 
    {
        return [
            'leagueId'     => 'id',
            'summonerId'   => 'summoner_id',
            'queueType'    => 'queue_type',
            'wins'         => 'wins',
            'losses'       => 'losses',
            'leagueName'   => 'league_name',
            'tier'         => 'tier',
            'rank'         => 'rank',
            'leaguePoints' => 'league_points',
        ];
    }
}
