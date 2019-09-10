<?php


namespace HuaweiFrsSdk\Client\Service;


use HuaweiFrsSdk\Access\FrsAccess;
use HuaweiFrsSdk\Client\Param\VideoLiveDetection\Actions;
use HuaweiFrsSdk\Common\FrsPaths;
use HuaweiFrsSdk\Common\VideoTypes;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

/**
 * Class LiveDetectService
 *
 * @package HuaweiFrsSdk\Client\Service
 */
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

    /**
     * @param string  $videoBase64
     * @param Actions $videoLiveDetectActions
     *
     * @return ResponseInterface
     */
    public function liveDetectByBase64( string $videoBase64, Actions $videoLiveDetectActions ): ResponseInterface
    {
        return $this->liveDetect(VideoTypes::BASE64,$videoBase64,$videoLiveDetectActions);
    }

    /**
     * @param string  $videoUrl
     * @param Actions $videoLiveDetectActions
     *
     * @return ResponseInterface
     */
    public function liveDetectByObsUrl( string $videoUrl, Actions $videoLiveDetectActions ): ResponseInterface
    {
        return $this->liveDetect(VideoTypes::OBS_URL,$videoUrl,$videoLiveDetectActions);
    }

    /**
     * @param string  $videoLocalFilePath
     * @param Actions $videoLiveDetectActions
     */
    public function liveDetectByLocalFile( string $videoLocalFilePath, Actions $videoLiveDetectActions ): void
    {
        // TODO
    }

    /**
     * @param string  $videoType
     * @param string  $video
     * @param Actions $videoLiveDetectActions
     *
     * @return ResponseInterface
     */
    private function liveDetect( string $videoType, string $video, Actions $videoLiveDetectActions ): ResponseInterface
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