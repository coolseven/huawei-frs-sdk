<?php


namespace HuaweiFrsSdk\Client\Param;


use JsonSerializable;

class ExternalFieldDefinition implements JsonSerializable
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
        $this->key  = $key;
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
        return [
            $this->key => [
                'type' => $this->type,
            ]
        ];
    }
}