<?php

namespace HuaweiFrsSdk\Client\Result\Common;


use HuaweiFrsSdk\Client\Param\ExternalFields;

class Face
{
    /**
     * @var SimpleFace
     */
    private $simpleFace;
    /**
     * @var string
     */
    private $externalImageId;
    /**
     * @var string
     */
    private $faceId;
    /**
     * @var ExternalFields
     */
    private $externalFields;

    public function __construct( SimpleFace $simpleFace, string $externalImageId, string $faceId, ExternalFields $externalFields )
    {

        $this->simpleFace = $simpleFace;
        $this->externalImageId = $externalImageId;
        $this->faceId = $faceId;
        $this->externalFields = $externalFields;
    }

    /**
     * @return SimpleFace
     */
    public function getSimpleFace() : SimpleFace
    {
        return $this->simpleFace;
    }

    /**
     * @param SimpleFace $simpleFace
     */
    public function setSimpleFace( SimpleFace $simpleFace ) : void
    {
        $this->simpleFace = $simpleFace;
    }

    /**
     * @return string
     */
    public function getExternalImageId() : string
    {
        return $this->externalImageId;
    }

    /**
     * @param string $externalImageId
     */
    public function setExternalImageId( string $externalImageId ) : void
    {
        $this->externalImageId = $externalImageId;
    }

    /**
     * @return string
     */
    public function getFaceId() : string
    {
        return $this->faceId;
    }

    /**
     * @param string $faceId
     */
    public function setFaceId( string $faceId ) : void
    {
        $this->faceId = $faceId;
    }

    /**
     * @return array
     */
    public function getExternalFields() : ExternalFields
    {
        return $this->externalFields;
    }

    /**
     * @param ExternalFields $externalFields
     */
    public function setExternalFields( ExternalFields $externalFields ) : void
    {
        $this->externalFields = $externalFields;
    }
}