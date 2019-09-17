<?php


namespace HuaweiFrsSdk\Client\Result\Common;


use HuaweiFrsSdk\Client\Param\ExternalFieldDefinitions;

class FaceSetInfo
{
    /**
     * @var string
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $number;
    /**
     * @var string
     */
    private $createDate;
    /**
     * @var int
     */
    private $capacity;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getNumber(): int
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getCreateDate(): string
    {
        return $this->createDate;
    }

    /**
     * @return int
     */
    public function getCapacity(): int
    {
        return $this->capacity;
    }

    /**
     * @return ExternalFieldDefinitions
     */
    public function getExternalFieldDefinitions(): ExternalFieldDefinitions
    {
        return $this->externalFieldDefinitions;
    }
    /**
     * @var ExternalFieldDefinitions
     */
    private $externalFieldDefinitions;

    public function __construct(
        string $id,
        string $name,
        int    $number,
        string $createDate,
        int    $capacity,
        ExternalFieldDefinitions $externalFieldDefinitions = null
    )
    {
        $this->id                       = $id;
        $this->name                     = $name;
        $this->number                   = $number;
        $this->createDate               = $createDate;
        $this->capacity                 = $capacity;
        $this->externalFieldDefinitions = $externalFieldDefinitions;
    }
}