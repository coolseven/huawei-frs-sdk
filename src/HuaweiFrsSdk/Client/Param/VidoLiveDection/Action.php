<?php


namespace HuaweiFrsSdk\Client\Param\VideoLiveDetection;


class Action
{
    /**
     * @var bool
     */
    private $enabled;
    /**
     * @var int
     */
    private $startOffset;
    /**
     * @var int
     */
    private $endOffset;

    public function __construct(bool $enabled, int $startOffset = 0, int $endOffset = 0 )
    {
        $this->enabled = $enabled;
        $this->startOffset = $startOffset;
        $this->endOffset = $endOffset;
    }

    /**
     * @return bool
     */
    public function isEnabled() : bool
    {
        return $this->enabled;
    }

    /**
     * @return string
     */
    public function getTimeRange() : string
    {
        if ($this->startOffset && $this->endOffset) {
            return $this->startOffset . '-' . $this->endOffset;
        }

        return '';
    }
}