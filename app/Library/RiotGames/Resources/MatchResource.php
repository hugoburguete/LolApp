<?php
namespace LolApplication\Library\RiotGames\Resources;

use Illuminate\Support\Collection;
use LolApplication\Library\RiotGames\ResourceObjects\Match;

class MatchResource extends RiotGamesResource
{
    /**
     * Retrieves a summoner's match list
     *
     * @param mixed $summoner
     * @return Collection
     */
    public function getMatchListByAccount(string $accountId): Collection
    {
        $path = $this->getRequestEndpoint([
            'service' => 'match',
            'resource' => 'matchlists/by-account/' . $accountId,
        ]);
        $response = $this->makeRequest('GET', $path);
        $response = json_decode($response);

        $matches = collect();
        if ($response->totalGames > 0) {
            foreach ($response->matches as $match) {
                $matches->push(Match::fromJson(json_encode($match)));
            }
        }
        return $matches;
    }
}
