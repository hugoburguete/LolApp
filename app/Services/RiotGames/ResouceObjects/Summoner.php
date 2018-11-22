<?php
namespace LolApplication\Services\RiotGames\ResourceObjects;

class Summoner extends BaseObject
{
    public $id;
    public $accountId;
    public $name;
    public $profileIconId;
    public $revisionDate;
    public $summonerLevel;

    public function __construct()
    {
        
    }
}
