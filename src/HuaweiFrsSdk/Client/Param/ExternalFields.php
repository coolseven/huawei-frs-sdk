<?php


namespace HuaweiFrsSdk\Client\Param;


class ExternalFields
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
}