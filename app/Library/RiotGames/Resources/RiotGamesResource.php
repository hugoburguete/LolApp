<?php
namespace LolApplication\Library\RiotGames\Resources;

use GuzzleHttp\Exception\RequestException;
use LolApplication\Library\RiotGames\Exceptions\HttpRequestException;
use LolApplication\Library\RiotGames\Resources\HttpResourceInterface;

class RiotGamesResource implements HttpResourceInterface
{
    protected $apiKey;
    
    /**
     * @var string Riot API endpoint for version 3
     */
    private const RIOT_ENDPOINT_V3 = 'https://%s.api.riotgames.com/lol/%s/v3/%s';

    /**
     * @var string Riot API endpoint for version 4
     */
    private const RIOT_ENDPOINT_V4 = 'https://%s.api.riotgames.com/lol/%s/v4/%s';

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
        self::REGION_EUW,
        self::REGION_NA,
        self::REGION_EUW,
        self::REGION_BR,
        self::REGION_EUN,
        self::REGION_JP,
        self::REGION_KR,
        self::REGION_LA1,
        self::REGION_LA2,
        self::REGION_NA,
        self::REGION_OC,
        self::REGION_TR,
        self::REGION_RU,
        self::REGION_PBE,
    ];

    /**
     * @var string The API region
     */
    private $region = self::REGION_EUW;

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
     * {@inhericDoc}
     */
    public function makeRequest(string $requestType, string $endpoint): string
    {
        $params = [
            'query' => [
                'api_key' => $this->apiKey,
            ]
        ];
        $client = new \GuzzleHttp\Client();
        try {
            $res = $client->request($requestType, $endpoint, $params);            
        } catch (RequestException $exception) {
            // TODO: Log this.
            throw new HttpRequestException(
                $this->getRequestExceptionMessage(), 
                $exception->getRequest(),
                $exception->hasResponse() ? $exception->getResponse() : null
            );
        }

        return $res->getBody();
    }

    /**
     * {@inhericDoc}
     */
    public function getRequestExceptionMessage(): string
    {
        return 'Error Processing Request';
    }

    /**
     * {@inhericDoc}
     */
    public function getRequestEndpoint(array $params, string $version = 'latest'): string
    {
        switch ($version) {
            case 'v3':
                return sprintf(self::RIOT_ENDPOINT_V3, $this->region, $params['service'], $params['resource']);
                break;
            case 'latest':
            default:
                return sprintf(self::RIOT_ENDPOINT_V4, $this->region, $params['service'], $params['resource']);
                break;
        }
    }
}
