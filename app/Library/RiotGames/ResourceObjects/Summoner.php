<?php
namespace LolApplication\Library\RiotGames\ResourceObjects;

use LolApplication\Library\RiotGames\ResourceObjects\Position;

class Summoner extends BaseObject
{
    public $id;
    public $accountId;
    public $puuid; // (Player Universally Unique Identifiers) aka playerId
    public $name;
    public $profileIconId;
    public $revisionDate;
    public $summonerLevel;

    public function __construct()
    {
        
    }
}
