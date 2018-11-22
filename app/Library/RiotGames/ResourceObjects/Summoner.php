<?php
namespace LolApplication\Library\RiotGames\ResourceObjects;

use LolApplication\Library\RiotGames\ResourceObjects\Position;

class Summoner extends BaseObject
{
    public $id;
    public $accountId;
    public $name;
    public $profileIconId;
    public $revisionDate;
    public $summonerLevel;
    public $positions = [];

    public function __construct()
    {
        
    }

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
}
