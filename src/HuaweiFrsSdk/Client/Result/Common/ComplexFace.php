<?php

namespace HuaweiFrsSdk\Client\Result\Common;


class ComplexFace
{
    /**
     * @var Face
     */
    private $face;
    /**
     * @var float
     */
    private $similarity;

    public function __construct( Face $face, float $similarity )
    {

        $this->face = $face;
        $this->similarity = $similarity;
    }

    /**
     * @return Face
     */
    public function getFace() : Face
    {
        return $this->face;
    }

    /**
     * @param Face $face
     */
    public function setFace( Face $face ) : void
    {
        $this->face = $face;
    }

    /**
     * @return float
     */
    public function getSimilarity() : float
    {
        return $this->similarity;
    }

    /**
     * @param float $similarity
     */
    public function setSimilarity( float $similarity ) : void
    {
        $this->similarity = $similarity;
    }
}