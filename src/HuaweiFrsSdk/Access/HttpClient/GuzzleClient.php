<?php


namespace HuaweiFrsSdk\Access\HttpClient;


use GuzzleHttp\Client;
use HuaweiFrsSdk\Access\HttpRequest\SignedRequest;
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

        $response = $client->post($r->getUri(),[
            'headers' => $r->getHeaders(),
            'body'  => $r->getBody(),
            'http_error' => true,
        ]);

        return $response;
    }
}