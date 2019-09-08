<?php
/**
 * PROJECT: huawei-frs-sdk
 * FILENAME: HttpResponse.php
 * HOMEPAGE: https://github.com/coolseven/huaweicloud-sdk-php-frs
 */

namespace HuaweiFrsSdk\Access;


class HttpResponse
{
    /**
     * @var int
     */
    private $httpCode;

    /**
     * @var array
     */
    private $headers;

    /**
     * @var string
     */
    private $body;

    /**
     * @return int
     */
    public function getHttpCode() : int
    {
        return $this->httpCode;
    }

    /**
     * @param int $httpCode
     */
    public function setHttpCode( int $httpCode ) : void
    {
        $this->httpCode = $httpCode;
    }

    /**
     * @return array
     */
    public function getHeaders() : array
    {
        return $this->headers;
    }

    /**
     * @param array $headers
     */
    public function setHeaders( array $headers ) : void
    {
        $this->headers = $headers;
    }

    /**
     * @return string
     */
    public function getBodyAsString() : string
    {
        return $this->body;
    }

    /**
     * @param string $body
     */
    public function setBody( string $body ) : void
    {
        $this->body = $body;
    }


}