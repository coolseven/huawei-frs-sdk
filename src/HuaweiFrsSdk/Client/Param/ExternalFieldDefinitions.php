<?php


namespace HuaweiFrsSdk\Client\Param;


use JsonSerializable;

class ExternalFieldDefinitions implements JsonSerializable
{
    /**
     * @var ExternalFieldDefinition[]
     */
    private $externalFieldDefinitions = [];

    /**
     * CreateExternalFields constructor.
     *
     * @param ExternalFieldDefinition[] $externalFieldDefinitions
     */
    public function __construct(array $externalFieldDefinitions = [])
    {
        foreach ($externalFieldDefinitions as $externalFieldDefinition) {
            $this->addExternalFieldDefinition($externalFieldDefinition);
        }
    }

    public function addExternalFieldDefinition(ExternalFieldDefinition $externalFieldDefinition): void
    {
        $this->externalFieldDefinitions[$externalFieldDefinition->getKey()] = ['type' => $externalFieldDefinition->getType()];
    }

    public function getExternalFieldDefinitions(): array
    {
        return $this->externalFieldDefinitions;
    }

    public function jsonSerialize()
    {
        return $this->externalFieldDefinitions;
    }
}