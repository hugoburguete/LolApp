<?php
namespace LolApplication\Library\RiotGames\Resources;

use GuzzleHttp\Exception\RequestException;
use LolApplication\Library\RiotGames\Exceptions\ResourceException;

interface HttpResourceInterface
{
    /**
     * Makes an HTTP request to Riots API
     *
     * @param string $requestType The type of request (POST, GET, etc...)
     * @param string $path The resource we're consuming
     * @return string The resource response
     * @throws HttpRequestException Http request has failed
     */
    function makeRequest(string $requestType, string $endpoint): string;

    /**
     * Returns the request exception message.
     * 
     * @return string the message
     */
    function getRequestExceptionMessage(): string;

    /**
     * Retrieves RIOTs API endpoint for a specific server
     *
     * @param string $server The server to fetch the information from
     * @param string $version The version of the API
     * @return string the endpoint
     */
    function getRequestEndpoint(array $params, string $version = 'latest'): string;
}
