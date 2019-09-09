<?php


namespace HuaweiFrsSdk\Client\Param\VideoLiveDetection;


class Actions
{


    /**
     * @var WaveHeadToLeftAction
     */
    private $waveHeadToLeftAction;
    /**
     * @var WaveHeadToRightAction
     */
    private $waveHeadToRightAction;
    /**
     * @var HeadNoddingAction
     */
    private $headNoddingAction;
    /**
     * @var MouthAction
     */
    private $mouthAction;

    public function __construct(
        WaveHeadToLeftAction $waveHeadToLeftAction ,
        WaveHeadToRightAction $waveHeadToRightAction ,
        HeadNoddingAction $headNoddingAction ,
        MouthAction $mouthAction
    )
    {
        $this->waveHeadToLeftAction = $waveHeadToLeftAction;
        $this->waveHeadToRightAction = $waveHeadToRightAction;
        $this->headNoddingAction = $headNoddingAction;
        $this->mouthAction = $mouthAction;
    }

    public function getActions()
    {
        $actions = [];

        if ($this->waveHeadToLeftAction->isEnabled()) {
            $actions[] = 1;
        }
        if ($this->waveHeadToRightAction->isEnabled()) {
            $actions[] = 2;
        }
        if ($this->headNoddingAction->isEnabled()) {
            $actions[] = 3;
        }
        if ($this->mouthAction->isEnabled()) {
            $actions[] = 4;
        }

        return implode(',',$actions);
    }

    public function getActionTime()
    {
        $action_time = [];

        if ($this->waveHeadToLeftAction->isEnabled()) {
            $action_time[] = $this->waveHeadToLeftAction->getTimeRange();
        }
        if ($this->waveHeadToRightAction->isEnabled()) {
            $action_time[] = $this->waveHeadToRightAction->getTimeRange();
        }
        if ($this->headNoddingAction->isEnabled()) {
            $action_time[] = $this->headNoddingAction->getTimeRange();
        }
        if ($this->mouthAction->isEnabled()) {
            $action_time[] = $this->mouthAction->getTimeRange();
        }

        return implode(',',$action_time);
    }
}