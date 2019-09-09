<?php


namespace HuaweiFrsSdk\Client\Param;


class ExternalField
{
    /**
     * @var string
     */
    private $key;
    /**
     * @var string
     */
    private $type;

    /**
     * ExternalField constructor.
     *
     * @param string $key
     * @param string $type
     */
    public function __construct(string $key, string $type)
    {
        $this->key = $key;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}