<?php
namespace LolApplication\Services\RiotGames;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use LolApplication\Models\League;
use LolApplication\Models\Match;
use LolApplication\Models\Summoner;
use LolApplication\Library\RiotGames\ResourceObjects\Summoner as SummonerResourceObject;
use LolApplication\Library\RiotGames\Resources\SummonerResource;
use LolApplication\Library\RiotGames\Resources\LeagueResource;
use LolApplication\Library\RiotGames\Resources\MatchResource;

class RiotGamesService implements RiotGamesInterface
{
    /**
     * Riot's Summoner Library Resource
     * @var SummonerResource
     */
    private $summonerResource;

    /**
     * Riot's League Library Resource
     * @var LeagueResource
     */
    private $leagueResource;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->summonerResource = resolve(SummonerResource::class);
        $this->leagueResource = resolve(LeagueResource::class);
        $this->matchResource = resolve(MatchResource::class);
    }

    /**
     * {@inheritDoc}
     */
    public function getSummoner(string $summonerName, bool $force = false): Summoner
    {
        $cacheKey = 'summonername:' . Str::slug($summonerName);

        if ($force) {
            $summoner = $this->buildSummoner($summonerName);
            Cache::put($cacheKey, $summoner);
        } else {
            $summoner = Cache::get($cacheKey, function() use ($summonerName) {
                return $this->buildSummoner($summonerName);
            });
        }

        return $summoner;
    }

    protected function buildSummoner(string $summonerName): Summoner
    {
        $summonerResourceObject = $this->summonerResource
            ->getSummoner($summonerName);
        $summoner = Summoner::with(['leagues', 'matches'])
            ->find($summonerResourceObject->id);

        if (empty($summoner)) {
            $summoner = $this->fetchSummoner($summonerName);
        }

        return $summoner;
    }

    protected function fetchSummoner(string $summonerName): Summoner
    {
        // Map summoner
        $summoner = Summoner::fromResourceObject($summonerResourceObject);

        // Fetch leagues
        $leagues = $this->leagueResource
            ->getPositionBySummoner($summoner);
        
        // Attach them to the summoner
        if (!$leagues->isEmpty()) {
            $leagues->each(function($item, $key) use ($summoner) {
                $league = League::fromResourceObject($item);
                $summoner->leagues->add($league);
            });
        }

        $matches = $this->matchResource
            ->getMatchListByAccount($summoner->account_id);

        // Attach them to the summoner
        if (!$matches->isEmpty()) {
            $matches->each(function($item, $key) use ($summoner) {
                $match = Match::fromResourceObject($item);
                $match->account_id = $summoner->account_id;
                $match->started_at = Carbon::createFromTimestamp($match->started_at / 1000)->toDateTimeString();
                $summoner->matches->add($match);
            });
        }
        $summoner->push();
    }
}
