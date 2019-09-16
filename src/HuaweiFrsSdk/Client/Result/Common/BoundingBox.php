<?php

namespace HuaweiFrsSdk\Client\Result\Common;


class BoundingBox
{
    /**
     * @var int
     */
    private $topLeftX;
    /**
     * @var int
     */
    private $topLeftY;
    /**
     * @var int
     */
    private $width;

    /**
     * @return int
     */
    public function getTopLeftX() : int
    {
        return $this->topLeftX;
    }

    /**
     * @param int $topLeftX
     */
    public function setTopLeftX( int $topLeftX ) : void
    {
        $this->topLeftX = $topLeftX;
    }

    /**
     * @return int
     */
    public function getTopLeftY() : int
    {
        return $this->topLeftY;
    }

    /**
     * @param int $topLeftY
     */
    public function setTopLeftY( int $topLeftY ) : void
    {
        $this->topLeftY = $topLeftY;
    }

    /**
     * @return int
     */
    public function getWidth() : int
    {
        return $this->width;
    }

    /**
     * @param int $width
     */
    public function setWidth( int $width ) : void
    {
        $this->width = $width;
    }

    /**
     * @return int
     */
    public function getHeight() : int
    {
        return $this->height;
    }

    /**
     * @param int $height
     */
    public function setHeight( int $height ) : void
    {
        $this->height = $height;
    }
    /**
     * @var int
     */
    private $height;

    public function __construct( int $topLeftX, int $topLeftY, int $width, int $height )
    {

        $this->topLeftX = $topLeftX;
        $this->topLeftY = $topLeftY;
        $this->width = $width;
        $this->height = $height;
    }
}