<?php


namespace HuaweiFrsSdk\Client\Result\Face;


use HuaweiFrsSdk\Client\Result\Common\Face;

class AddFaceResult
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
     * @return Face[]
     */
    public function getFaces() : array
    {
        return $this->faces;
    }

    /**
     * @var $faces Face[]
     */
    private $faces;

    public function __construct(string $faceSetId, string $faceSetName, array $faces = [] )
    {
        $this->faceSetId = $faceSetId;
        $this->faceSetName = $faceSetName;
        $this->faces = $faces;
    }
}