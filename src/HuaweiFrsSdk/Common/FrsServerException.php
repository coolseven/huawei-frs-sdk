<?php
/**
 * PROJECT: huawei-frs-sdk
 * FILENAME: FrsServerException.php
 * HOMEPAGE: https://github.com/coolseven/huaweicloud-sdk-php-frs
 */

namespace HuaweiFrsSdk\Common;


use HuaweiFrsSdk\Access\HttpResponse;
use HuaweiFrsSdk\Access\SignedHttpRequest;

class FrsServerException extends \Exception
{
    private $request;
    private $response;

    public function __construct( SignedHttpRequest $request, HttpResponse $response, $message = '', $code = 0, \Exception $previous = null )
    {
        $this->request = $request;
        $this->response = $response;

        parent::__construct( $message, $code, $previous );
    }

    /**
     * @return SignedHttpRequest
     */
    public function getRequest() : SignedHttpRequest
    {
        return $this->request;
    }

    /**
     * @return HttpResponse
     */
    public function getResponse() : HttpResponse
    {
        return $this->response;
    }
}