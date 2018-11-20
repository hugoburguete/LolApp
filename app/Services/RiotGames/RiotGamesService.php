<?php
namespace LolApplication\Services\RiotGames;

use ResourceObjects\Summoner;

class RiotGamesService implements RiotGamesInterface
{
    protected $apiKey;
    
    /**
     * @var string Riot API endpoint for version 3
     */
    private const RIOT_ENDPOINT_V3 = 'https://%s.api.riotgames.com/lol/%s/v3/%s';

    private const REGION_EU = 'eu';
    private const REGION_NA = 'na';

    private const ALLOWED_REGIONS = [
        RiotGamesService.REGION_EU,
        RiotGamesService.REGION_NA,
    ];

    /**
     * @var string The API region
     */
    private $region = 'eu';

    /**
     * Constructor
     */
    public function __construct(string $apiKey)
    {
        $this->apiKey = $apiKey;
    }

    /**
     * {@inheritDoc}
     */
    public function getSummoner(string $summonerName): Summoner
    {
        $path = $this->getApiEndpoint([
            'service' => 'summoner',
            'resource' => 'summoners/by-name/' . $summonerName,
        ]);
        $response = $this->makeApiCall('GET', $path);
        return Summoner::toJson($response);
    }

    /**
     * {@inheritDoc}
     */
    public function setRegion(string $region): void
    {
        $this->region = $region;
    }

    /**
     * Checks if the region is valid
     *
     * @param string $region
     * @return boolean true if it's a known region, false otherwise.
     */
    public function isValidRegion(string $region): boolean
    {
        return in_array($refion, self::ALLOWED_REGIONS);
    }

    /**
     * Makes an HTTP request to Riots API
     *
     * @param string $requestType The type of request (POST, GET, etc...)
     * @param string $path The resource we're consuming
     * @return string The resource response
     */
    protected function makeApiCall(string $requestType, string $endpoint): string
    {
        $params = [
            'api_key' => $this->apiKey,
        ];

        $client = new \GuzzleHttp\Client();
        $res = $client->request($requestType, $params);
        return $res->getBody();
    }

    /**
     * Retrieves RIOTs API endpoint for a specific server
     *
     * @param string $server The server to fetch the information from
     * @param string $version The version of the API
     * @return string the endpoint
     */
    protected function getApiEndpoint(array $params, string $version = 'latest'): string
    {
        switch ($version) {
            case 'latest':
            default:
                return sprintf(self::RIOT_ENDPOINT_V3, $this->region, $params['service'], $params['resource']);
                break;
        }
    }
}
