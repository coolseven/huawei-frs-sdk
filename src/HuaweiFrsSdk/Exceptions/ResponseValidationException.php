<?php


namespace HuaweiFrsSdk\Exceptions;



use Exception;
use Psr\Http\Message\ResponseInterface;

class ResponseValidationException extends Exception
{
    /**
     * @var ResponseInterface
     */
    private $originalResponse;

    public function __construct(ResponseInterface $originalResponse, $message)
    {
        parent::__construct($message . ' ,response body: '. $originalResponse->getBody()->getContents());

        $this->originalResponse = $originalResponse;
    }

    /**
     * @return ResponseInterface
     */
    public function getOriginalResponse(): ResponseInterface
    {
        return $this->originalResponse;
    }
}