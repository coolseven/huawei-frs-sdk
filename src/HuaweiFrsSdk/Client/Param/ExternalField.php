<?php


namespace HuaweiFrsSdk\Client\Param;


class ExternalField
{
    /**
     * @var string
     */
    private $key;
    /**
     * @var
     */
    private $value;

    public function __construct(string $key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}