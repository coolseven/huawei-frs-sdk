<?php

namespace HuaweiFrsSdk\Access;


use GuzzleHttp\Psr7\Uri;
use HuaweiFrsSdk\Access\HttpClient\GuzzleClient;
use HuaweiFrsSdk\Access\HttpRequest\ContentTypes;
use HuaweiFrsSdk\Access\HttpRequest\HttpMethods;
use HuaweiFrsSdk\Access\HttpRequest\UnSignedRequest;
use HuaweiFrsSdk\Access\Signer\Signer;
use HuaweiFrsSdk\Client\Param\AuthInfo;
use Psr\Http\Message\ResponseInterface;

class FrsAccess
{
    /**
     * @var AuthInfo
     */
    private $authInfo;
    /**
     * @var GuzzleClient
     */
    private $httpClient;
    /**
     * @var Signer
     */
    private $signer;

    /**
     * FrsAccess constructor.
     *
     * @param AuthInfo $authInfo
     * @param int      $connectionTimeout
     */
    public function __construct( AuthInfo $authInfo, int $connectionTimeout )
    {
        $this->authInfo = $authInfo;

        $this->signer = new Signer($authInfo->getAk(), $authInfo->getSk());

        $this->httpClient = new GuzzleClient($connectionTimeout);
    }

    public function get(string $uri,string $contentType = ContentTypes::JSON): ResponseInterface
    {
        $unsignedRequest = $this->createUnsignedRequest(HttpMethods::GET,$uri,null,$contentType);

        $signedRequest = $this->signer->sign($unsignedRequest);

        return $this->httpClient->access($signedRequest);
    }

    /**
     * @param string $uri
     * @param array|null  $body
     * @param string $contentType
     *
     * @return ResponseInterface
     */
    public function post( string $uri,array $body , string $contentType = ContentTypes::JSON): ResponseInterface
    {
        $unsignedRequest = $this->createUnsignedRequest(HttpMethods::POST,$uri,$body,$contentType);

        $signedRequest = $this->signer->sign($unsignedRequest);

        return $this->httpClient->access($signedRequest);
    }

    public function delete(string $uri, array $body = [] , string $contentType = ContentTypes::JSON): ResponseInterface
    {
        $unsignedRequest = $this->createUnsignedRequest(HttpMethods::DELETE,$uri,$body,$contentType);

        $signedRequest = $this->signer->sign($unsignedRequest);

        return $this->httpClient->access($signedRequest);
    }

    /**
     * @param string     $method
     * @param string     $uri
     * @param array|null $body
     * @param string     $contentType
     *
     * @return UnSignedRequest
     */
    private function createUnsignedRequest(string $method, string $uri, $body , string $contentType) : UnSignedRequest
    {
        $scheme = parse_url($this->authInfo->getEndpoint(),PHP_URL_SCHEME);
        $host = parse_url($this->authInfo->getEndpoint(),PHP_URL_HOST);

        $requestUri = $scheme . '://' . $host . $uri;

        if (empty($body)) {
            $bodyString = '';
        }else{
            $bodyString = \GuzzleHttp\json_encode($body);
        }

        $unsignedRequest = new UnSignedRequest(
            $method,
            new Uri($requestUri),
            ['content-type' => $contentType],
            $bodyString
        );

        return $unsignedRequest;
    }

}