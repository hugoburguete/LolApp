<?php
namespace LolApplication\Http\Controllers\Api;

use Illuminate\Http\Request;
use LolApplication\Http\Controllers\Controller;
use LolApplication\Services\RiotGames\RiotGamesInterface;
use LolApplication\Library\RiotGames\Exceptions\HttpRequestException;

class SummonerController extends Controller
{
    /**
     * @var RiotGamesService The riot games service
     */
    protected $ritoPls;

    /**
     * Constructor
     */
    public function __construct(RiotGamesInterface $ritoPls)
    {
        $this->ritoPls = $ritoPls;
    }

    /**
     * Get summoner
     */
    public function get(Request $request, $summoner)
    {
        $summoner = $this->ritoPls->getSummonerByName($summoner);
        return response()->json($summoner);
    }
}