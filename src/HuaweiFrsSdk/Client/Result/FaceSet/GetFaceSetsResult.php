<?php


namespace HuaweiFrsSdk\Client\Result\FaceSet;


use HuaweiFrsSdk\Client\Result\Common\FaceSetInfo;

class GetFaceSetsResult
{
    /**
     * @var FaceSetInfo[]
     */
    private $faceSetsInfo;

    /**
     * @return FaceSetInfo[]
     */
    public function getFaceSetsInfo(): array
    {
        return $this->faceSetsInfo;
    }

    /**
     * GetFaceSetsResult constructor.
     *
     * @param FaceSetInfo[] $faceSetsInfo
     */
    public function __construct(array $faceSetsInfo)
    {
        $this->faceSetsInfo = $faceSetsInfo;
    }
}