<?php


namespace HuaweiFrsSdk\Client\Param;


class FaceDetectionAttributes
{
    /**
     * @var bool
     */
    private $headPose;
    /**
     * @var bool
     */
    private $gender;
    /**
     * @var bool
     */
    private $age;
    /**
     * @var bool
     */
    private $keyPoints;
    /**
     * @var bool
     */
    private $dress;
    /**
     * @var bool
     */
    private $smile;

    public function __construct(
        bool $headPose,
        bool $gender,
        bool $age,
        bool $keyPoints,
        bool $dress,
        bool $smile
    )
    {
        $this->headPose = $headPose;
        $this->gender = $gender;
        $this->age = $age;
        $this->keyPoints = $keyPoints;
        $this->dress = $dress;
        $this->smile = $smile;
    }

    /**
     * @return string
     */
    public function getWantedAttributes(): string
    {
        $wanted = [];

        if ($this->headPose) {
            $wanted[] = 0;
        }

        if ($this->gender) {
            $wanted[] = 1;
        }

        if ($this->age) {
            $wanted[] = 2;
        }

        if ($this->keyPoints) {
            $wanted[] = 3;
        }

        if ($this->dress) {
            $wanted[] = 4;
        }

        if ($this->smile) {
            $wanted[] = 5;
        }

        return implode(',',$wanted);
    }
}