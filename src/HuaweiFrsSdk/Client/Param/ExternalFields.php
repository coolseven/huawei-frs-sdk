<?php


namespace HuaweiFrsSdk\Client\Param;


use JsonSerializable;

class ExternalFields implements JsonSerializable
{
    /**
     * @var array
     */
    private $externalFields = [];

    public function __construct(array $externalFields = [])
    {
        foreach ($externalFields as $externalField) {
            $this->addExternalField($externalField);
        }
    }

    public function addExternalField(ExternalField $externalField): void
    {
        $this->externalFields[$externalField->getKey()] = $externalField->getValue();
    }

    /**
     * @return array
     */
    public function getExternalFields(): array
    {
        return $this->externalFields;
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
        return $this->externalFields;
    }
}