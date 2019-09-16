<?php

namespace HuaweiFrsSdk\Client\Result\Search;


use HuaweiFrsSdk\Client\Result\Common\ComplexFace;

class SearchFaceResult
{
    /**
     * @return ComplexFace[]
     */
    public function getComplexFaces() : array
    {
        return $this->complexFaces;
    }

    /**
     * @var $complexFaces ComplexFace[]
     */
    private $complexFaces;

    public function __construct(array $complexFaces = [] )
    {
        $this->complexFaces = $complexFaces;
    }
}