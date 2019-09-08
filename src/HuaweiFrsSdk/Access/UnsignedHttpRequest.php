<?php
/**
 * PROJECT: huawei-frs-sdk
 * FILENAME: UnsignedHttpRequest.php
 * HOMEPAGE: https://github.com/coolseven/huaweicloud-sdk-php-frs
 */

namespace HuaweiFrsSdk\Access;


class UnsignedHttpRequest
{
    public const METHOD_POST   = 'POST';
    public const METHOD_GET    = 'GET';
    public const METHOD_PUT    = 'PUT';
    public const METHOD_DELETE = 'DELETE';

    public const SCHEME_HTTPS      = 'https';
    public const CONTENT_TYPE_JSON = 'application/json';

    private $method = '';
    private $scheme = '';
    private $host = '';
    private $uri = '';
    private $query = [];
    private $headers = [];
    private $body = '';

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
    public function getQuery() : array
    {
        return $this->query;
    }

    /**
     * @param array $query
     */
    public function setQuery( array $query ) : void
    {
        $this->query = $query;
    }

    /**
     * @return array
     */
    public function getHeaders() : array
    {
        return $this->headers;
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

    public function setContentType( string $contentType )
    {
        $this->addHeader('content-type',$contentType);
    }

    private function addHeader( string $headerKey, string $headerValue ) : void
    {
        $this->headers[$headerKey] = $headerValue;
    }
}