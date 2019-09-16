<?php


namespace HuaweiFrsSdk\Client\Result\FaceSet;


class DeleteFaceSetResult
{
    /**
     * @return string
     */
    public function getFaceSetName(): string
    {
        return $this->faceSetName;
    }
    /**
     * @var string
     */
    private $faceSetName;

    public function __construct(string $faceSetName)
    {
        $this->faceSetName = $faceSetName;
    }
}