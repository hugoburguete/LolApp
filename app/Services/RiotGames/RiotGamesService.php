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
     * Riot's Match Library Resource
     * @var LeagueResource
     */
    private $matchResource;

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
    public function getSummonerByName(string $summonerName, bool $force = false): Summoner
    {
        Cache::flush();

        $cacheKey = 'summoner:byname:' . Str::slug($summonerName);

        if ($force) {
            $summoner = $this->fetchSummonerByName($summonerName);
            Cache::put($cacheKey, $summoner);
        } else {
            $summoner = Cache::rememberForever($cacheKey, function() use ($summonerName) {
                return $this->buildSummoner($summonerName);
            });
        }

        return $summoner;
    }

    /**
     * {@inheritDoc}
     */
    public function getSummonerById(string $summonerId, bool $force = false): Summoner
    {
        $cacheKey = 'summoner:byid:' . $summonerId;

        if ($force) {
            $summoner = $this->fetchSummonerById($summonerId);
            Cache::put($cacheKey, $summoner);
        } else {
            $summoner = Cache::rememberForever($cacheKey, function() use ($summonerId) {
                // Find summoner By ID
                $summoner = Summoner::with($this->getSummonerRelationships())->find($summonerId);

                if (!empty($summoner)) {
                    return $summoner;
                }

                // Okay, maybe we don't have it. Fetch it from the API
                return $this->fetchSummonerById($summonerId);               
            });
        }

        return $summoner;
    }

    protected function buildSummoner(string $summonerName): Summoner
    {
        // Is it on our database?
        $summoner = Summoner::with($this->getSummonerRelationships())
            ->where(['name' => $summonerName])
            ->first();

        if (!empty($summoner)) {
            return $summoner;
        }

        // okay, maybe it's a different name format. Find its ID and try again
        $summonerResourceObject = $this->summonerResource->getSummonerByName($summonerName);
        Cache::put('summonerresource:' . $summonerResourceObject->id, $summonerResourceObject);

        return $this->getSummonerById($summonerResourceObject->id);
    }

    protected function fetchSummonerByName(string $summonerName): Summoner
    {
        // Fetch summoner //
        $summonerResourceObject = $this->summonerResource
            ->getSummonerByName($summonerName);
        Cache::put('summonerresource:' . $summonerResourceObject->id, $summonerResourceObject);

        return $this->fetchSummonerById($summonerResourceObject->id);
    }

    protected function fetchSummonerById(string $summonerId): Summoner
    {
        // Fetch summoner //
        $summonerResourceObject = Cache::rememberForever('summonerresource:' . $summonerId, function() use ($summonerId) {
            return $this->summonerResource
                ->getSummonerById($summonerId);
        });

        // Map summoner //
        $summoner = Summoner::fromResourceObject($summonerResourceObject);

        // Fetch leagues //
        $leagues = $this->leagueResource
            ->getPositionBySummoner($summoner);
        
        // Attach them to the summoner
        if (!$leagues->isEmpty()) {
            $leagues->each(function($item, $key) use ($summoner) {
                $league = League::fromResourceObject($item);
                $summoner->leagues->add($league);
            });
        }

        // Find matches //

        // Find last match
        $lastMatch = $summoner->matches()->orderBy('started_at', 'desc')->latest()->first();

        // Set date range if we have lastMatch and it's within a week
        $startAt = null;
        $endAt = null;
        if (!empty($lastMatch)) {
            $today = Carbon::now();
            if ($lastMatch->started_at->diffInSeconds($today) <= $today->diffInSeconds($today->copy()->addWeek())) {
                $startAt = $lastMatch->started_at->addMinutes(1)->format('U') * 1000;
                $endAt = Carbon::now()->format('U') * 1000;
            }
        }

        sleep(10);

        try {
            $matches = $this->matchResource
                ->getMatchListByAccount($summoner->account_id, $startAt, $endAt);
        } catch (HttpRequestException $exception) {
            // TODO: Handle this
            $matches = collect();
        }

        sleep(10);

        // Attach them to the summoner
        if (!$matches->isEmpty()) {
            $matches->each(function($item, $key) use ($summoner) {
                $match = Match::fromResourceObject($item);
                $match->account_id = $summoner->account_id;
                try {
                    $match->started_at = Carbon::createFromTimestampMs($match->started_at)->toDateTimeString();
                } catch (\Exception $e) {
                    dd($match, $item);
                }
                $summoner->matches->add($match);
            });
        }
        $summoner->push();

        return Summoner::with($this->getSummonerRelationships())->find($summoner->id);
    }

    /**
     * Just a helper
     *
     * @return array The summoner relationships
     */
    private function getSummonerRelationships(): array 
    {
        return ['leagues', 'matches'];
    }
}
