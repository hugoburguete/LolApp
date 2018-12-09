<?php

namespace LolApplication\Models;

use LolApplication\Models\BaseModel;
use LolApplication\Models\Summoner;

class Match extends BaseModel
{
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
			'gameId'      => 'id',
			'platformId'  => 'platform_id',
			'champion_id' => 'championId',
			'queue'       => 'queue',
			'season'      => 'season',
			'lane'        => 'lane',
			'timestamp'   => 'started_at',
        ];
    }
}
