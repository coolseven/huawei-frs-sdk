<?php
/**
 * PROJECT: huawei-frs-sdk
 * FILENAME: SignedHttpRequest.php
 * HOMEPAGE: https://github.com/coolseven/huaweicloud-sdk-php-frs
 */

namespace HuaweiFrsSdk\Access;


final class SignedHttpRequest
{
    public const METHOD_POST   = 'POST';
    public const METHOD_GET    = 'GET';
    public const METHOD_PUT    = 'PUT';
    public const METHOD_DELETE = 'DELETE';

    public const SCHEME_HTTPS  = 'https';

    private $method = '';
    private $scheme = '';
    private $host = '';
    private $uri = '';
    private $headers = [];
    private $body = '';
    private $queryString = '';

    /**
     * @return string
     */
    public function getMethod() : string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod( string $method ) : void
    {
        $this->method = $method;
    }

    /**
     * @return string
     */
    public function getScheme() : string
    {
        return $this->scheme;
    }

    /**
     * @param string $scheme
     */
    public function setScheme( string $scheme ) : void
    {
        $this->scheme = $scheme;
    }

    /**
     * @return string
     */
    public function getHost() : string
    {
        return $this->host;
    }

    /**
     * @param string $host
     */
    public function setHost( string $host ) : void
    {
        $this->host = $host;
    }

    /**
     * @return string
     */
    public function getUri() : string
    {
        return $this->uri;
    }

    /**
     * @param string $uri
     */
    public function setUri( string $uri ) : void
    {
        $this->uri = $uri;
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
    public function getBody() : string
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

    /**
     * @param string $headerKey
     * @param string $headerValue
     */
    public function addHeader( string $headerKey, string $headerValue ) : void
    {
        $this->headers[$headerKey] = $headerValue;
    }

    /**
     * @return string
     */
    public function getQueryString( ) : string
    {
        return $this->queryString;
    }

    /**
     * @param string $queryString
     */
    public function setQueryString( string $queryString ) : void
    {
        $this->queryString = $queryString;
    }
}