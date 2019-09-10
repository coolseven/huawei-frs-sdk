<?php

namespace HuaweiFrsSdk\Client\Service;


use HuaweiFrsSdk\Access\FrsAccess;
use HuaweiFrsSdk\Client\Param\FaceDetectionAttributes;
use HuaweiFrsSdk\Common\FrsPaths;
use HuaweiFrsSdk\Common\ImageTypes;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

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

    /**
     * @param string                  $imageBas464
     * @param FaceDetectionAttributes $detectionAttributes
     *
     * @return ResponseInterface
     */
    public function detectFaceByBas464( string $imageBas464 , FaceDetectionAttributes $detectionAttributes): ResponseInterface
    {
        return $this->detectFace(ImageTypes::BASE64,$imageBas464,$detectionAttributes);
    }

    /**
     * @param string                  $imageObsUrl
     * @param FaceDetectionAttributes $detectionAttributes
     *
     * @return ResponseInterface
     */
    public function detectFaceByObsUrl( string $imageObsUrl, FaceDetectionAttributes $detectionAttributes): ResponseInterface
    {
        return $this->detectFace(ImageTypes::OBS_URL,$imageObsUrl,$detectionAttributes);
    }

    /**
     * @param string                  $localFilePath
     * @param FaceDetectionAttributes $detectionAttributes
     *
     * @return ResponseInterface
     */
    public function detectFaceByLocalFile( string $localFilePath, FaceDetectionAttributes $detectionAttributes ): ResponseInterface
    {
        $uri = sprintf(FrsPaths::FACE_DETECT, $this->projectId);

        $body = [];

        if (!empty($detectionAttributes->getWantedAttributes())) {
            $body['multipart'][] = [
                'name' => 'attributes',
                'contents' => $detectionAttributes->getWantedAttributes(),
            ];
        }

        $body['multipart'][] = [
            'name'     => 'image_file',
            'contents' => fopen($localFilePath, 'rb'),
        ];

        return $this->accessService->post($uri,$body);
    }

    /**
     * @param string                  $imageType
     * @param string                  $image
     * @param FaceDetectionAttributes $detectionAttributes
     *
     * @return ResponseInterface
     */
    private function detectFace( string $imageType, string $image, FaceDetectionAttributes $detectionAttributes ): ResponseInterface
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
                throw new InvalidArgumentException("imageType must be one of base64  / obs_url ,$imageType given");
        }

        if (!empty($detectionAttributes->getWantedAttributes())) {
            $body['attributes'] = $detectionAttributes->getWantedAttributes();
        }

        return $this->accessService->post($uri,$body);
    }
}