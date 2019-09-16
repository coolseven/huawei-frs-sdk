<?php


namespace HuaweiFrsSdk\Client\Result\FaceSet;


use HuaweiFrsSdk\Client\Result\Common\FaceSetInfo;

class CreateFaceSetResult
{
    /**
     * @return FaceSetInfo
     */
    public function getFaceSetInfo(): FaceSetInfo
    {
        return $this->faceSetInfo;
    }
    /**
     * @var FaceSetInfo
     */
    private $faceSetInfo;

    /**
     * CreateFaceSetResult constructor.
     *
     * @param FaceSetInfo $faceSetInfo
     */
    public function __construct(FaceSetInfo $faceSetInfo)
    {
        $this->faceSetInfo = $faceSetInfo;
    }
}