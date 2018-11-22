<?php
namespace LolApplication\Services\RiotGames;

use LolApplication\Services\RiotGames\ResourceObjects\Summoner;

class RiotGamesService implements RiotGamesInterface
{
    protected $apiKey;
    
    /**
     * @var string Riot API endpoint for version 3
     */
    private const RIOT_ENDPOINT_V3 = 'https://%s.api.riotgames.com/lol/%s/v3/%s';

    /**
     * Region identifiers
     */
    private const REGION_EUW = 'euw1';
    private const REGION_BR = 'br1';
    private const REGION_EUN = 'eun1';
    private const REGION_JP = 'jp1';
    private const REGION_KR = 'kr';
    private const REGION_LA1 = 'la1';
    private const REGION_LA2 = 'la2';
    private const REGION_NA = 'na1';
    private const REGION_OC = 'oc1';
    private const REGION_TR = 'tr1';
    private const REGION_RU = 'ru';
    private const REGION_PBE = 'pbe1';

    /**
     * @var array Valid region identifiers
     */
    private const ALLOWED_REGIONS = [
        RiotGamesService::REGION_EUW,
        RiotGamesService::REGION_NA,
        RiotGamesService::REGION_EUW,
        RiotGamesService::REGION_BR,
        RiotGamesService::REGION_EUN,
        RiotGamesService::REGION_JP,
        RiotGamesService::REGION_KR,
        RiotGamesService::REGION_LA1,
        RiotGamesService::REGION_LA2,
        RiotGamesService::REGION_NA,
        RiotGamesService::REGION_OC,
        RiotGamesService::REGION_TR,
        RiotGamesService::REGION_RU,
        RiotGamesService::REGION_PBE,
    ];

    /**
     * @var string The API region
     */
    private $region = RiotGamesService::REGION_EUW;

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
        return Summoner::fromJson($response);
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
            'query' => [
                'api_key' => $this->apiKey,
            ]
        ];
        $client = new \GuzzleHttp\Client();
        $res = $client->request($requestType, $endpoint, $params);
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
