<?php

namespace HuaweiFrsSdk\Client\Service;


use HuaweiFrsSdk\Access\FrsAccess;
use HuaweiFrsSdk\Client\Param\FaceDetectionAttributes;
use HuaweiFrsSdk\Common\FrsPaths;
use HuaweiFrsSdk\Common\ImageTypes;
use InvalidArgumentException;

class DetectService
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

    public function detectFaceByBas464( string $imageBas464 , FaceDetectionAttributes $detectionAttributes)
    {
        return $this->detectFace(ImageTypes::BASE64,$imageBas464,$detectionAttributes);
    }

    public function detectFaceByObsUrl( string $imageObsUrl, FaceDetectionAttributes $detectionAttributes)
    {
        return $this->detectFace(ImageTypes::OBS_URL,$imageObsUrl,$detectionAttributes);
    }

    public function detectFaceByLocalFile( string $localFilePath, FaceDetectionAttributes $detectionAttributes )
    {
        // TODO
    }

    private function detectFace( string $imageType, string $image, FaceDetectionAttributes $detectionAttributes )
    {
        $uri = sprintf(FrsPaths::FACE_DETECT, $this->projectId);

        $body = [];

        switch ( $imageType ) {
            case ImageTypes::BASE64:
                $body['image_base64'] = $image;
                break;
            case ImageTypes::OBS_URL:
                $body['image_url'] = $image;
                break;
            default:
                throw new InvalidArgumentException("imageType must be one of image_base64  / image_url ,but $imageType provided");
        }

        if (!empty($detectionAttributes->getWantedAttributes())) {
            $body['attributes'] = $detectionAttributes->getWantedAttributes();
        }

        return $this->accessService->post($uri,$body);
    }
}