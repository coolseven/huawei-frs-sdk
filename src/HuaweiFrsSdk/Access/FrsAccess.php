<?php
/**
 * PROJECT: huawei-frs-sdk
 * FILENAME: FrsAccess.php
 * HOMEPAGE: https://github.com/coolseven/huaweicloud-sdk-php-frs
 */

namespace HuaweiFrsSdk\Access;


use HuaweiFrsSdk\Access\HttpClient\CurlClient;
use HuaweiFrsSdk\Client\Param\AuthInfo;

class FrsAccess
{
    /**
     * @var AuthInfo
     */
    private $authInfo;
    /**
     * @var int
     */
    private $connectionTimeout;
    /**
     * @var CurlClient
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
        $this->connectionTimeout = $connectionTimeout;

        $this->signer = new Signer($authInfo->getAk(), $authInfo->getSk());
        $this->httpClient = new CurlClient($connectionTimeout);
    }

    /**
     * @param string $uri
     * @param array  $body
     * @param string $contentType
     *
     * @return HttpResponse
     * @throws \HuaweiFrsSdk\Common\FrsClientException
     * @throws \HuaweiFrsSdk\Common\FrsServerException
     */
    public function post( string $uri,array $body , string $contentType = UnsignedHttpRequest::CONTENT_TYPE_JSON) : HttpResponse
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
     * @return UnsignedHttpRequest
     */
    private function createUnsignedRequest( string $uri, array $body , string $contentType) : UnsignedHttpRequest
    {
        $unsignedRequest = new UnsignedHttpRequest();
        $unsignedRequest->setMethod(UnsignedHttpRequest::METHOD_POST);
        $unsignedRequest->setScheme(UnsignedHttpRequest::SCHEME_HTTPS);
        $unsignedRequest->setHost($this->authInfo->getEndpoint());
        $unsignedRequest->setUri($uri);
        $unsignedRequest->setContentType($contentType);
        $unsignedRequest->setBody(json_encode($body));

        return $unsignedRequest;
    }
}