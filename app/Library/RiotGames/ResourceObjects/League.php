<?php
namespace LolApplication\Library\RiotGames\ResourceObjects;

class League extends BaseObject
{
    /**
     * Queue identifier
     *
     * @var string
     */
    public $queueType;

    /**
     * Whether the summoner is on a hot streak or not
     *
     * @var bool
     */
    public $hotStreak;

    /**
     * The amount of ranked wins the summoner has
     *
     * @var int
     */
    public $wins;

    /**
     * Is the summoner not a newbie?
     *
     * @var bool
     */
    public $veteran;

    /**
     * The amount of ranked losses the summoner has
     *
     * @var bool
     */
    public $losses;

    /**
     * Encripted summoner id
     *
     * @var string
     */
    public $summonerId;

    /**
     * The league name
     *
     * @var string
     */
    public $leagueName;

    /**
     * Is the user inactive
     *
     * @var bool
     */
    public $inactive;

    /**
     * Division number
     *
     * @var string
     */
    public $rank;

    /**
     * New player?!
     *
     * @var bool
     */
    public $freshBlood;

    /**
     * League identifier
     *
     * @var string
     */
    public $leagueId;

    /**
     * Division name
     *
     * @var string
     */
    public $tier;

    /**
     * LP
     *
     * @var int
     */
    public $leaguePoints;

    public function __construct()
    {
        
    }
}
