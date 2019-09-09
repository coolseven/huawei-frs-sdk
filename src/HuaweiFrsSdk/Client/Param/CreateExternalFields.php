<?php


namespace HuaweiFrsSdk\Client\Param;


class CreateExternalFields
{
    /**
     * @var ExternalField[]
     */
    private $externalFields;

    /**
     * CreateExternalFields constructor.
     *
     * @param ExternalField[] $externalFields
     */
    public function __construct(array $externalFields = [])
    {
        foreach ($externalFields as $externalField) {
            $this->addExternalField($externalField);
        }
    }

    public function addExternalField(ExternalField $externalField): void
    {
        $this->externalFields[$externalField->getKey()] = ['type' => $externalField->getType()];
    }

    public function getExternalFields(): array
    {
        return $this->externalFields;
    }
}