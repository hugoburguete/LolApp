<?php
namespace LolApplication\Services\RiotGames;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
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

        return Cache::get($cacheKey, function() use ($summonerName): Summoner {
            $summonerResourceObject = $this->summonerResource
                ->getSummoner($summonerName);
            $summoner = Summoner::where([
                    'externalId' => $summonerResourceObject->id,
                    'externalPlayerUniqueId' => $summonerResourceObject->puuid,
                ])->first();
                
            if (empty($summoner)) {
                $summoner = Summoner::fromResourceObject($summonerResourceObject);
                $summoner->save();
            }

            $leagues = $this->leagueResource
                ->getPositionBySummoner($summoner);
            // $summoner->addPositions($leagues);
            dd($leagues);

            return $summoner;
        });
    }

    public function getSummonerById(string $summonerId, boolean $force)
    {

    }
}
