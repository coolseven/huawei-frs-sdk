<?php


namespace HuaweiFrsSdk\Client\Param;


class ExternalFieldDefinitions
{
    /**
     * @var ExternalFieldDefinition[]
     */
    private $externalFieldDefinitions = [];

    /**
     * CreateExternalFields constructor.
     *
     * @param ExternalFieldDefinition[] $externalFields
     */
    public function __construct(array $externalFields = [])
    {
        foreach ($externalFields as $externalField) {
            $this->addExternalFieldDefinition($externalField);
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
}