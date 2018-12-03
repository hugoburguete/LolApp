<?php
namespace LolApplication\Services\RiotGames;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use LolApplication\Models\League;
use LolApplication\Models\Summoner;
use LolApplication\Library\RiotGames\ResourceObjects\Summoner as SummonerResourceObject;
use LolApplication\Library\RiotGames\Resources\SummonerResource;
use LolApplication\Library\RiotGames\Resources\LeagueResource;

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
        $summoner = Summoner::with('leagues')
            ->find($summonerResourceObject->id);
            
        if (empty($summoner)) {
            $summoner = Summoner::fromResourceObject($summonerResourceObject);
            $summoner->save();
        }

        if ($summoner->leagues->isEmpty()) {
            $leagues = $this->leagueResource
                ->getPositionBySummoner($summoner);

            $leagues->each(function($item, $key) use ($summoner) {
                $league = League::fromResourceObject($item);
                $summoner->leagues()->save($league);
            });
        }

        return $summoner;
    }
}
