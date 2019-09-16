<?php


namespace HuaweiFrsSdk\Access\HttpResponse;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

/**
 * Class AbstractResponse
 *
 * @method int getStatusCode()
 * @method string getReasonPhrase()
 * @method array getHeader($header)
 * @method string getProtocolVersion()
 * @method boolean hasHeader($header)
 * @method string getHeaderLine($header)
 * @method StreamInterface getBody()
 *
 * @package HuaweiFrsSdk\Access\HttpResponse
 */
abstract class AbstractResponse
{
    /**
     * @var ResponseInterface
     */
    protected $response;
    /**
     * @var array
     */
    protected $body;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;

        $this->body = \GuzzleHttp\json_decode($this->response->getBody()->getContents(),true);

        if ($this->response->getBody()->isSeekable()) {
            $this->response->getBody()->rewind();
        }

        $this->validate();
    }

    public function __call($method,$args)
    {
        return call_user_func_array([$this->response, $method], $args);
    }

    abstract public function validate();

    abstract public function getResult();
}