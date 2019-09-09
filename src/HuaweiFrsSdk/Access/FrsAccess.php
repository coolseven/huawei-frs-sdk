<?php
/**
 * PROJECT: huawei-frs-sdk
 * FILENAME: FrsAccess.php
 * HOMEPAGE: https://github.com/coolseven/huaweicloud-sdk-php-frs
 */

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

    /**
     * @param string $uri
     * @param array  $body
     * @param string $contentType
     *
     * @return ResponseInterface
     */
    public function post( string $uri,array $body , string $contentType = ContentTypes::JSON): ResponseInterface
    {
        $unsignedRequest = $this->createUnsignedRequest($uri,$body,$contentType);

        $signedRequest = $this->signer->sign($unsignedRequest);

        return $this->httpClient->access($signedRequest);
    }

    /**
     * @param string $uri
     * @param array  $body
     * @param string $contentType
     *
     * @return UnSignedRequest
     */
    private function createUnsignedRequest( string $uri, array $body , string $contentType) : UnSignedRequest
    {
        $scheme = parse_url($this->authInfo->getEndpoint(),PHP_URL_SCHEME);
        $host = parse_url($this->authInfo->getEndpoint(),PHP_URL_HOST);

        $requestUri = $scheme . '://' . $host . $uri;

        $unsignedRequest = new UnSignedRequest(
            HttpMethods::POST,
            new Uri($requestUri),
            ['content-type' => $contentType],
            \GuzzleHttp\json_encode($body)
        );

        return $unsignedRequest;
    }
}