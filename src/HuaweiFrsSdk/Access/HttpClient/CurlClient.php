<?php
/**
 * PROJECT: huawei-frs-sdk
 * FILENAME: CurlClient.php
 * HOMEPAGE: https://github.com/coolseven/huaweicloud-sdk-php-frs
 */

namespace HuaweiFrsSdk\Access\HttpClient;

use HuaweiFrsSdk\Access\HttpResponse;
use HuaweiFrsSdk\Access\SignedHttpRequest;
use HuaweiFrsSdk\Common\FrsClientException;
use HuaweiFrsSdk\Common\FrsServerException;

class CurlClient
{
    /**
     * @var int
     */
    private $connectionTimeOutInSeconds;

    /**
     * CurlClient constructor.
     *
     * @param int $connectionTimeOutInSeconds
     */
    public function __construct( int $connectionTimeOutInSeconds )
    {
        $this->connectionTimeOutInSeconds = $connectionTimeOutInSeconds;
    }

    /**
     * @param SignedHttpRequest $r
     *
     * @return HttpResponse
     * @throws FrsClientException
     * @throws FrsServerException
     */
    public function access( SignedHttpRequest $r ) : HttpResponse
    {
        $url = $this->calcCurlUrl($r);
        $headers = $this->calcCurlHeaders($r);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $r->getMethod());
        curl_setopt($curl, CURLOPT_POSTFIELDS, $r->getBody());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_NOBODY, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);


        try {
            $httpStatusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $httpResponseHeaders = []; // TODO
            $httpResponseBody = curl_exec($curl);
        } finally{
            curl_close($curl);
        }

        $response = new HttpResponse();
        $response->setHttpCode($httpStatusCode);
        $response->setHeaders($httpResponseHeaders);
        $response->setBody($httpResponseBody);

        if (200 < $httpStatusCode && $httpStatusCode < 500 ) {
            throw new FrsClientException($r, $response,$httpResponseBody,$httpStatusCode);
        }
        if (500 <= $httpStatusCode) {
            throw new FrsServerException($r, $response,$httpResponseBody,$httpStatusCode);
        }
        return $response;
    }

    /**
     * @param SignedHttpRequest $r
     *
     * @return string
     */
    private function calcCurlUrl( SignedHttpRequest $r ) : string
    {
        return $r->getScheme() .'://'. $r->getHost() . $r->getUri() . $r->getQueryString();
    }

    /**
     * @param SignedHttpRequest $r
     *
     * @return array
     */
    private function calcCurlHeaders( SignedHttpRequest $r ) : array
    {
        $header = array();
        foreach ($r->getHeaders() as $key => $value) {
            array_push($header, strtolower($key) . ':' . trim($value));
        }
        return $header;
    }
}