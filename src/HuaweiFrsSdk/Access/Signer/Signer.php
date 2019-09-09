<?php


namespace HuaweiFrsSdk\Access\Signer;


use HuaweiFrsSdk\Access\HttpRequest\SignedRequest;
use HuaweiFrsSdk\Access\HttpRequest\UnSignedRequest;

class Signer
{
    private const HEADER_X_SDK_DATE    = 'X-Sdk-Date';
    private const HEADER_AUTHORIZATION = 'Authorization';

    private const DATE_FORMAT              = 'Ymd\THis\Z';
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
     * @param UnSignedRequest $unsignedRequest
     *
     * @return SignedRequest
     */
    public function sign(UnSignedRequest $unsignedRequest): SignedRequest
    {
        date_default_timezone_set('UTC');
        $timestamp = time();

        $presetTimestamp = $unsignedRequest->getHeader(self::HEADER_X_SDK_DATE);
        if (count($presetTimestamp) === 1) {
            $timestamp = date_timestamp_get(date_create_from_format(self::DATE_FORMAT, $presetTimestamp[0]));
        }

        $signed = new SignedRequest(
            $unsignedRequest->getMethod(),
            $unsignedRequest->getUri(),
            $unsignedRequest->getHeaders(),
            $unsignedRequest->getBody()
        );

        /** @var SignedRequest $signed */
        $signed = $signed->withAddedHeader(self::HEADER_X_SDK_DATE,date(self::DATE_FORMAT,$timestamp));

        /** @var SignedRequest $signed */
        $signed = $signed->withAddedHeader(self::HEADER_AUTHORIZATION,$this->calcAuthorizationHeader($signed,$timestamp));

        return $signed;
    }

    private function calcAuthorizationHeader(SignedRequest $signed, int $timestamp): string
    {
        $signedHeaderKeys = $this->calcSignedHeaderKeys($signed->getHeaders());

        $canonicalRequest = $this->calcCanonicalRequest($signed,$signedHeaderKeys);

        $signature = $this->calcSignature($canonicalRequest,$timestamp);

        $signedHeaderKeysString = implode(';', $signedHeaderKeys);

        return "SDK-HMAC-SHA256 Access={$this->ak}, SignedHeaders=$signedHeaderKeysString, Signature=$signature";
    }

    private function calcSignedHeaderKeys(array $headers): array
    {
        $signedHeaderKeys = [];
        foreach ( $headers as $key => $value ) {
            $signedHeaderKeys[] = strtolower($key);
        }
        sort($signedHeaderKeys);

        return $signedHeaderKeys;
    }

    private function calcCanonicalRequest(SignedRequest $signed, array $signedHeaderKeys): string
    {
        $method = $signed->getMethod();

        $path = $this->calcCanonicalUri($signed->getUri()->getPath());

        $queryString = $this->calcCanonicalQueryString($signed->getUri()->getQuery());

        $headers = $this->calcCanonicalHeaders($signed->getHeaders(),$signedHeaderKeys);

        $signedHeaderKeysString = implode(';',$signedHeaderKeys);

        $hash = hash('sha256',$signed->getBody()->getContents());

        return "$method\n$path\n$queryString\n$headers\n$signedHeaderKeysString\n$hash";
    }

    private function calcCanonicalUri(string $uri): string
    {
        $pattens = explode('/', $uri);
        $canonicalUri = [];
        foreach ($pattens as $v) {
            $canonicalUri[] = $this->escape($v);
        }
        $canonicalUriString = implode('/', $canonicalUri);
        if (substr($canonicalUriString, -1) !== '/') {
            $canonicalUriString .= '/';
        }
        return $canonicalUriString;
    }

    private function calcCanonicalQueryString(string $queryString): string
    {
        if (empty($queryString)) {
            $query = [];
        }else{
            parse_str($queryString,$query);
        }

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
                $queryPairs[] = $escapedKey . '=' . $escapedValue;
            }
        }

        return implode('&',$queryPairs);
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

    private function calcCanonicalHeaders(array $headers, array $signedHeaderKeys): string
    {
        $lowerCasedHeaders = [];
        foreach ( $headers as $unsignedHeaderKey => $unsignedHeaderValues) {
            $lowerCasedHeaders[ strtolower($unsignedHeaderKey)] = trim($unsignedHeaderValues[0]);
        }

        $canonicalHeaders = [];
        foreach ($signedHeaderKeys as $key) {
            $canonicalHeaders[] = $key. ':'. $lowerCasedHeaders[$key];
        }
        return implode("\n", $canonicalHeaders) . "\n";
    }

    /**
     * @param $canonicalRequest
     * @param $timestamp
     *
     * @return string
     */
    private function calcSignature($canonicalRequest,$timestamp): string
    {
        $date = date(self::DATE_FORMAT, $timestamp);

        $hash = hash('sha256', $canonicalRequest);

        $stringToSign = "SDK-HMAC-SHA256\n$date\n$hash";

        return hash_hmac('sha256', $stringToSign, $this->sk);
    }
}