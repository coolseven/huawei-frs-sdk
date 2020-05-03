<?php


namespace HuaweiFrsSdk\Client\Result\Face;


use HuaweiFrsSdk\Client\Result\Common\Face;

class GetFaceResult
{
    /**
     * @var string
     */
    private $faceSetId;

    /**
     * @return string
     */
    public function getFaceSetId() : string
    {
        return $this->faceSetId;
    }

    /**
     * @return string
     */
    public function getFaceSetName() : string
    {
        return $this->faceSetName;
    }
    /**
     * @var string
     */
    private $faceSetName;

    /**
     * @return Face
     */
    public function getFace() : Face
    {
        return $this->face;
    }

    /**
     * @var $face Face
     */
    private $face;

    public function __construct(string $faceSetId, string $faceSetName, $face )
    {
        $this->faceSetId = $faceSetId;
        $this->faceSetName = $faceSetName;
        $this->face = $face;
    }
}