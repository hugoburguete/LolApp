<?php
namespace LolApplication\Http\Controllers\Api;

use LolApplication\Http\Controllers\Controller;
use LolApplication\Services\RiotGames\RiotGamesServiceInterface;

class SummonerController extends Controller
{
    /**
     * @var RiotGamesService The riot games service
     */
    protected $ritoPls;

    /**
     * Constructor
     */
    public function __construct(RiotGamesServiceInterface $ritoPls)
    {
        $this->ritoPls = $ritoPls;
    }

    /**
     * Get summoner
     */
    public function get($summoner)
    {
        $summoner = $this->ritoPls->getSummoner($summoner);

        return response()->json($summoner);
    }
}