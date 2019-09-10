<?php

namespace HuaweiFrsSdk\Client\Result\Common;


class SimpleFace
{
    /**
     * @var BoundingBox
     */
    private $boundingBox;

    public function __construct( BoundingBox $boundingBox )
    {

        $this->boundingBox = $boundingBox;
    }

    /**
     * @return BoundingBox
     */
    public function getBoundingBox() : BoundingBox
    {
        return $this->boundingBox;
    }

    /**
     * @param BoundingBox $boundingBox
     */
    public function setBoundingBox( BoundingBox $boundingBox ) : void
    {
        $this->boundingBox = $boundingBox;
    }
}