<?php

namespace LolApplication\Models;

use LolApplication\Models\BaseModel;
use LolApplication\Models\Summoner;

class Match extends BaseModel
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'started_at',
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
        return $this->belongsTo(Summonner::class, 'account_id', 'account_id');
    }

    /**
     * {@inheritDoc}
     */
    protected static function getResourceMap(): array 
    {
        return [
            'gameId'     => 'id',
            'platformId' => 'platform_id',
            'champion'   => 'champion_id',
            'queue'      => 'queue',
            'season'     => 'season',
            'lane'       => 'lane',
            'timestamp'  => [
                'key'  => 'started_at',
                'type' => 'date',
            ],
        ];
    }
}
