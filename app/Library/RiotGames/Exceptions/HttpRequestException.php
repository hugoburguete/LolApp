<?php
namespace LolApplication\Library\RiotGames\Exceptions;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Riot API Resource HTTP exception
 */
class HttpRequestException extends \Exception
{
	/**
	 * @var RequestInterface
	 */
    protected $request;

	/**
	 * @var ResponseInterface
	 */
    protected $response;

    public function __construct(
    	string $message, 
    	RequestInterface $request, 
    	ResponseInterface $response = null
    ) {
    	$this->message = $message;
    	$this->request = $request;
    	$this->response = $response;
    }
}
