<?php

namespace HuaweiFrsSdk\Client\Result;


use HuaweiFrsSdk\Client\Result\Common\ComplexFace;

class SearchFaceResult
{
    /**
     * @var $complexFaces ComplexFace[]
     */
    private $complexFaces;

    public function __construct(array $complexFaces = [] )
    {
        $this->complexFaces = $complexFaces;
    }
}