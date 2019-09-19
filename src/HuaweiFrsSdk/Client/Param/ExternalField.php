<?php


namespace HuaweiFrsSdk\Client\Param;


use JsonSerializable;

class ExternalField implements JsonSerializable
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
        $this->key   = $key;
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

    /**
     * Specify data which should be serialized to JSON
     *
     * @link  https://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [$this->key => $this->value];
    }
}