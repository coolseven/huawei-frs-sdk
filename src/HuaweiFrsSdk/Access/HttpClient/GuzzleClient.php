<?php


namespace HuaweiFrsSdk\Access\HttpClient;


use GuzzleHttp\Client;
use HuaweiFrsSdk\Access\HttpRequest\HttpMethods;
use HuaweiFrsSdk\Access\HttpRequest\SignedRequest;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

class GuzzleClient
{
    /**
     * @var int
     */
    private $connectionTimeOutInSeconds;

    public function __construct( int $connectionTimeOutInSeconds )
    {
        $this->connectionTimeOutInSeconds = $connectionTimeOutInSeconds;
    }

    /**
     * @param SignedRequest $r
     *
     * @return ResponseInterface
     */
    public function access(SignedRequest $r): ResponseInterface
    {
        $client = new Client([
            'timeout'  => $this->connectionTimeOutInSeconds,
        ]);

        $method = strtoupper($r->getMethod());

        switch ($method) {
            case HttpMethods::GET:
                return $client->get($r->getUri(),[
                    'headers' => $r->getHeaders(),
                    'body'  => $r->getBody(),
                    'http_error' => true,
                ]);
            case HttpMethods::POST:
                return $client->post($r->getUri(),[
                    'headers' => $r->getHeaders(),
                    'body'  => $r->getBody(),
                    'http_error' => true,
                ]);
            case HttpMethods::DELETE:
                return $client->delete($r->getUri(),[
                    'headers' => $r->getHeaders(),
                    'body'  => $r->getBody(),
                    'http_error' => true,
                ]);
            default:
                throw new InvalidArgumentException(
                    "Invalid Http Method. http method should be one of get/post/put/delete/head , {$method} given.");
        }
    }
}