<?php

namespace HuaweiFrsSdk\Access;


use GuzzleHttp\Psr7\MultipartStream;
use GuzzleHttp\Psr7\Uri;
use HuaweiFrsSdk\Access\HttpClient\GuzzleClient;
use HuaweiFrsSdk\Access\HttpRequest\ContentTypes;
use HuaweiFrsSdk\Access\HttpRequest\HttpMethods;
use HuaweiFrsSdk\Access\HttpRequest\UnSignedRequest;
use HuaweiFrsSdk\Access\Signer\Signer;
use HuaweiFrsSdk\Client\Param\AuthInfo;
use InvalidArgumentException;
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

    public function get(string $uri): ResponseInterface
    {
        $unsignedRequest = $this->createUnsignedRequest(HttpMethods::GET,$uri,null,ContentTypes::JSON);

        $signedRequest = $this->signer->sign($unsignedRequest);

        return $this->httpClient->access($signedRequest);
    }

    /**
     * @param string     $uri
     * @param array|null $body
     *
     * @return ResponseInterface
     */
    public function post( string $uri,array $body): ResponseInterface
    {
        $unsignedRequest = $this->createUnsignedRequest(HttpMethods::POST,$uri,$body,ContentTypes::JSON);

        $signedRequest = $this->signer->sign($unsignedRequest);

        return $this->httpClient->access($signedRequest);
    }

    public function postMultipartFormData(string $uri,array $body): ResponseInterface
    {
        $unsignedRequest = $this->createUnsignedRequest(HttpMethods::POST,$uri,$body,ContentTypes::MULTIPART);

        $signedRequest = $this->signer->sign($unsignedRequest);

        return $this->httpClient->access($signedRequest);
    }

    public function delete(string $uri, array $body = []): ResponseInterface
    {
        $unsignedRequest = $this->createUnsignedRequest(HttpMethods::DELETE,$uri,$body,ContentTypes::JSON);

        $signedRequest = $this->signer->sign($unsignedRequest);

        return $this->httpClient->access($signedRequest);
    }

    public function put( string $uri, array $body = [] ): ResponseInterface
    {
        $unsignedRequest = $this->createUnsignedRequest(HttpMethods::PUT,$uri,$body,ContentTypes::JSON);

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

        switch ($contentType) {
            case ContentTypes::JSON:
                $unsignedRequest = new UnSignedRequest(
                    $method,
                    new Uri($requestUri),
                    ['content-type' => $contentType],
                    empty($body) ? '' : \GuzzleHttp\json_encode($body)
                );
                break;
            case ContentTypes::MULTIPART:
                if (!isset($body['multipart'])) {
                    throw new InvalidArgumentException('multipart not found in body!');
                }

                $bodyStream = new MultipartStream($body['multipart']);
                $boundaryString = "; boundary={$bodyStream->getBoundary()}";
                $unsignedRequest = new UnSignedRequest(
                    $method,
                    new Uri($requestUri),
                    ['content-type' => ContentTypes::MULTIPART . $boundaryString],
                    $bodyStream
                );
                break;
            default:
                throw new InvalidArgumentException("contentType should be one of application/json or multipart/form-data, $contentType given.");
        }

        return $unsignedRequest;
    }

}