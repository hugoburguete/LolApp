<?php
namespace LolApplication\Library\RiotGames\Resources;

use Illuminate\Support\Collection;
use LolApplication\Library\RiotGames\Exceptions\ValidationException;
use LolApplication\Library\RiotGames\ResourceObjects\Match;

class MatchResource extends RiotGamesResource
{
    /**
     * Retrieves a summoner's match list
     *
     * @param mixed $summoner
     * @return Collection
     */
    public function getMatchListByAccount(string $accountId, ?int $beginTime = null, ?int $endTime = null): Collection
    {
        $path = $this->getRequestEndpoint([
            'service' => 'match',
            'resource' => 'matchlists/by-account/' . $accountId,
        ]);
        $payload = [];
        if ($endTime !== null) {
            if ($beginTime !== null) {
                // The API can only handle matches within the range of a week.
                if ($endTime - $beginTime > (7 * 24 * 60 * 60 * 1000 * 1000)) {
                    throw new ValidationException('There can only be 1 week difference between beginTime and endTime');
                }
                $payload['beginTime'] = $beginTime;
            }
            $payload['endTime'] = $endTime;
        }
 
        $response = $this->makeRequest('GET', $path, $payload);
        $response = json_decode($response);

        $matches = collect();
        if (!empty($response) && $response->totalGames > 0) {
            foreach ($response->matches as $match) {
                $matches->push(Match::fromJson(json_encode($match)));
            }
        }
        return $matches;
    }
}
