<?php
namespace LolApplication\Library\RiotGames\ResourceObjects;

class Match extends BaseObject
{
    /**
     * Region the game was played on
     *
     * @var string
     */
    public $platformId;

    /**
     * The match Id
     *
     * @var int
     */
    public $gameId;

    /**
     * The account Id
     *
     * @var string
     */
    public $accountId;

    /**
     * The Id of the champion played
     *
     * @var int
     */
    public $champion;

    /**
     * ¯\_(ツ)_/¯
     *
     * @var int
     */
    public $queue;

    /**
     * The season it was played on.
     *
     * @var int
     */
    public $season;

    /**
     * When the match started
     *
     * @var long
     */
    public $timestamp;

    /**
     * The lane played
     *
     * @var string
     */
    public $lane;

    public function __construct()
    {
        
    }
}
