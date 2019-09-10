<?php


namespace HuaweiFrsSdk\Client\Param;


class ExternalFieldDefinitions
{
    /**
     * @var ExternalFieldDefinition[]
     */
    private $externalFields;

    /**
     * CreateExternalFields constructor.
     *
     * @param ExternalFieldDefinition[] $externalFields
     */
    public function __construct(array $externalFields = [])
    {
        foreach ($externalFields as $externalField) {
            $this->addExternalField($externalField);
        }
    }

    public function addExternalField(ExternalFieldDefinition $externalField): void
    {
        $this->externalFields[$externalField->getKey()] = ['type' => $externalField->getType()];
    }

    public function getExternalFields(): array
    {
        return $this->externalFields;
    }
}