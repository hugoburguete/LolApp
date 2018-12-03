<?php
namespace LolApplication\Models;

use LolApplication\Library\RiotGames\ResourceObjects\Summoner as SummonerResourceObject;
use LolApplication\Models\BaseModel;
use LolApplication\Library\RiotGames\ResourceObjects\BaseObject;

class Summoner extends BaseModel
{
    /**
     * TODO: The positions should be models with relationships
     */



    /**
     * Adds a ranked position to this summoner.
     *
     * @param Position $position
     * @return void
     */
    public function addPosition(Position $position)
    {
        $this->positions[$position->queueType] = $position;
    }

    /**
     * Adds multiple ranked position to this summoner.
     *
     * @param Position $position
     * @return void
     */
    public function addPositions(array $positions)
    {
        foreach ($positions as $position) {
            $this->addPosition($position);
        }
    }

    /**
     * Retrieves all summoner positions
     *
     * @return void
     */
    public function getPositions()
    {
        return $this->positions;
    }

    /**
     * {@inheritDoc}
     */
    protected static function getResourceMap(): array 
    {
        return [
            'id' => 'externalId',
            'accountId' => 'externalPlayerId',
            'puuid' => 'externalPlayerUniqueId',
            'name' => 'name',
            'profileIconId' => 'profileIconId',
            'summonerLevel' => 'level',
        ];
    }
}
