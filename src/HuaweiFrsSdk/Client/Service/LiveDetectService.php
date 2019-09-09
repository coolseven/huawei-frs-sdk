<?php


namespace HuaweiFrsSdk\Client\Service;


use HuaweiFrsSdk\Access\FrsAccess;
use HuaweiFrsSdk\Client\Param\VideoLiveDetection\Actions;
use HuaweiFrsSdk\Common\FrsPaths;
use HuaweiFrsSdk\Common\VideoTypes;
use InvalidArgumentException;

class LiveDetectService
{
    /**
     * @var FrsAccess
     */
    private $accessService;
    /**
     * @var string
     */
    private $projectId;

    /**
     * SearchService constructor.
     *
     * @param FrsAccess $accessService
     * @param string    $projectId
     */
    public function __construct( FrsAccess $accessService, string $projectId)
    {
        $this->accessService = $accessService;
        $this->projectId = $projectId;
    }

    public function liveDetectByBase64( string $videoBase64, Actions $videoLiveDetectActions )
    {
        return $this->liveDetect(VideoTypes::BASE64,$videoBase64,$videoLiveDetectActions);
    }

    public function liveDetectByObsUrl( string $videoUrl, Actions $videoLiveDetectActions )
    {
        return $this->liveDetect(VideoTypes::OBS_URL,$videoUrl,$videoLiveDetectActions);
    }

    public function liveDetectByLocalFile( string $videoLocalFilePath, Actions $videoLiveDetectActions )
    {
        // TODO
    }

    private function liveDetect( string $videoType, string $video, Actions $videoLiveDetectActions )
    {
        $uri = sprintf(FrsPaths::LIVE_DETECT, $this->projectId);

        $body = [];

        switch ( $videoType ) {
            case VideoTypes::BASE64:
                $body['video_base64'] = $video;
                break;
            case VideoTypes::OBS_URL:
                $body['video_url'] = $video;
                break;
            default:
                throw new InvalidArgumentException("$videoType must be one of base64  / obs_url ,$videoType given");
        }

        $body['actions'] = $videoLiveDetectActions->getActions();

        if (!empty($videoLiveDetectActions->getActionTime())) {
            $body['action_time'] = $videoLiveDetectActions->getActionTime();
        }

        return $this->accessService->post($uri,$body);
    }
}