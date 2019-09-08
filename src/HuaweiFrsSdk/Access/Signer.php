<?php
/**
 * PROJECT: huawei-frs-sdk
 * FILENAME: Signer.php
 * HOMEPAGE: https://github.com/coolseven/huaweicloud-sdk-php-frs
 */

namespace HuaweiFrsSdk\Access;


class Signer
{

    const HEADER_KEY_X_SDK_DATE    = 'X-Sdk-Date';
    const HEADER_KEY_AUTHORIZATION = 'Authorization';

    const DATE_FORMAT              = 'Ymd\THis\Z';
    /**
     * @var string
     */
    private $ak;
    /**
     * @var string
     */
    private $sk;

    /**
     * Signer constructor.
     *
     * @param string $ak
     * @param string $sk
     */
    public function __construct( string $ak, string $sk )
    {
        $this->ak = $ak;
        $this->sk = $sk;
    }

    /**
     * @param UnsignedHttpRequest $unsignedHttpRequest
     *
     * @return SignedHttpRequest
     */
    public function sign( UnsignedHttpRequest $unsignedHttpRequest ) : SignedHttpRequest
    {
        date_default_timezone_set('UTC');
        $timestamp = time();

        $signed = new SignedHttpRequest();

        $signed->setMethod($unsignedHttpRequest->getMethod());
        $signed->setScheme($unsignedHttpRequest->getScheme());
        $signed->setHost($unsignedHttpRequest->getHost());

        $signed->setQueryString($this->calcQueryString($unsignedHttpRequest->getQuery()));
        $signed->setUri($this->calcUri($unsignedHttpRequest->getUri()));

        $signed->setHeaders($unsignedHttpRequest->getHeaders());

        $signed->addHeader(self::HEADER_KEY_X_SDK_DATE,date(self::DATE_FORMAT,$timestamp));
        $signed->addHeader(self::HEADER_KEY_AUTHORIZATION,$this->calcHeaderAuthorization($unsignedHttpRequest,$timestamp));

        $signed->setBody($unsignedHttpRequest->getBody());
        return new SignedHttpRequest();
    }


    /**
     * @param array $query
     *
     * @return string
     */
    private function calcQueryString( array $query ) : string
    {
        $queryString = $this->calcCanonicalQueryString($query);
        return $queryString === ''
            ? $queryString
            : '?' . $queryString
            ;
    }

    /**
     * @param array $query
     *
     * @return string
     */
    private function calcCanonicalQueryString( array $query ) : string
    {
        $keys = [];
        foreach ( $query as $key => $value ) {
            $keys[] = $key;
        }
        sort($keys);

        $queryPairs = [];
        foreach ( $keys as $key ) {
            $value = $query[$key];

            $escapedKey = $this->escape($key);

            $values = is_array($value) ? $value : [$value];

            sort($values);
            foreach ( $values as $value ) {
                $escapedValue = $this->escape($value);
                $queryPairs[] = "$escapedKey" . '=' . $escapedValue;
            }
        }

        return join('&',$queryPairs);
    }

    /**
     * @param string $string
     *
     * @return mixed
     */
    private function escape( string $string )
    {
        $entities = ['+' , '%7E'];
        $replacements = ['%20' , '~'];

        return str_replace($entities, $replacements, urlencode($string));
    }

    /**
     * @param array $headers
     *
     * @return array
     */
    private function calcSignedHeaderKeys( array $headers ) : array
    {
        $signedHeaderKeys = [];
        foreach ( $headers as $key => $value ) {
            $signedHeaderKeys[] = strtolower($key);
        }
        sort($signedHeaderKeys);

        return $signedHeaderKeys;
    }

    /**
     * @param UnsignedHttpRequest $unsignedHttpRequest
     * @param int                 $timestamp
     *
     * @return string
     */
    private function calcHeaderAuthorization( UnsignedHttpRequest $unsignedHttpRequest ,int $timestamp ) : string
    {
        $signedHeaderKeys = $this->calcSignedHeaderKeys($unsignedHttpRequest->getHeaders());

        $canonicalRequest = $this->calcCanonicalRequest($unsignedHttpRequest,$signedHeaderKeys);

        $date = date(self::HEADER_KEY_X_SDK_DATE, $timestamp);

        $hash = hash('sha256', $canonicalRequest);

        $stringToSign = "SDK-HMAC-SHA256\n$date\n$hash";

        $signature = hash_hmac("sha256", $stringToSign, $this->sk);

        $signedHeaderKeysString = join(";", $signedHeaderKeys);

        return "SDK-HMAC-SHA256 Access={$this->ak}, SignedHeaders=$signedHeaderKeysString, Signature=$signature";
    }

    /**
     * @param UnsignedHttpRequest $unsignedHttpRequest
     * @param                     $signedHeaderKeys
     *
     * @return string
     */
    private function calcCanonicalRequest( UnsignedHttpRequest $unsignedHttpRequest,$signedHeaderKeys) : string
    {
        $method = $unsignedHttpRequest->getMethod();

        $uri = $this->calcCanonicalUri($unsignedHttpRequest->getUri());

        $queryString = $this->calcCanonicalQueryString($unsignedHttpRequest->getQuery());

        $headers = $this->calcCanonicalHeaders($unsignedHttpRequest->getHeaders(),$signedHeaderKeys);

        $signedHeaderKeysString = join(';',$signedHeaderKeys);

        $hash = hash('sha256',$unsignedHttpRequest->getBody());

        return "$method\n$uri\n$queryString\n$headers\n$signedHeaderKeysString\n$hash";
    }

    /**
     * @param string $uri
     *
     * @return string
     */
    private function calcCanonicalUri( string $uri ) : string
    {
        $pattens = explode("/", $uri);
        $canonicalUri = [];
        foreach ($pattens as $v) {
            array_push($canonicalUri, $this->escape($v));
        }
        $canonicalUriString = join("/", $canonicalUri);
        if (substr($canonicalUriString, -1) != "/") {
            $canonicalUriString = $canonicalUriString . "/";
        }
        return $canonicalUriString;
    }

    /**
     * @param array $headers
     * @param array $signedHeaderKeys
     *
     * @return string
     */
    private function calcCanonicalHeaders( array $headers ,array $signedHeaderKeys) : string
    {
        $lowerCasedHeaders = [];
        foreach ( $headers as $unsignedHeaderKey => $unsignedHeaderValue) {
            $lowerCasedHeaders[ strtolower($unsignedHeaderKey)] = trim($unsignedHeaderValue);
        }

        $canonicalHeaders = [];
        foreach ($signedHeaderKeys as $key) {
            $canonicalHeaders[] = $key. ':'. $lowerCasedHeaders[$key];
        }
        return join("\n", $canonicalHeaders) . "\n";
    }

    /**
     * @param string $unsignedUri
     *
     * @return mixed
     */
    private function calcUri( string $unsignedUri )
    {
        return str_replace(array("%2F"), array("/"), rawurlencode($unsignedUri));
    }

}