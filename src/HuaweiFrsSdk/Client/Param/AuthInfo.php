<?php
/**
 * PROJECT: huawei-frs-sdk
 * FILENAME: AuthInfo.php
 * HOMEPAGE: https://github.com/coolseven/huaweicloud-sdk-php-frs
 */

namespace HuaweiFrsSdk\Client\Param;


class AuthInfo
{
    /**
     * @var string
     */
    private $endpoint;
    /**
     * @var string
     */
    private $ak;
    /**
     * @var string
     */
    private $sk;

    public function __construct( string $endpoint, string $ak, string $sk)
    {
        $this->endpoint = $endpoint;
        $this->ak = $ak;
        $this->sk = $sk;
    }

    /**
     * @return string
     */
    public function getEndpoint() : string
    {
        return $this->endpoint;
    }

    /**
     * @return string
     */
    public function getAk() : string
    {
        return $this->ak;
    }

    /**
     * @return string
     */
    public function getSk() : string
    {
        return $this->sk;
    }

}