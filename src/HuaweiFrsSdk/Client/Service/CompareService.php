<?php

namespace HuaweiFrsSdk\Client\Service;


use HuaweiFrsSdk\Access\FrsAccess;
use HuaweiFrsSdk\Common\FrsPaths;
use HuaweiFrsSdk\Common\ImageTypes;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

class CompareService
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
     * @param string $image1Base64
     * @param string $image2Base64
     *
     * @return ResponseInterface
     */
    public function compareFaceByBase64( string $image1Base64, string $image2Base64 ): ResponseInterface
    {
        return $this->compareFace(ImageTypes::BASE64, $image1Base64, $image2Base64);
    }

    /**
     * @param string $image1ObsUrl
     * @param string $image2ObsUrl
     *
     * @return ResponseInterface
     */
    public function compareFaceByObsUrl( string $image1ObsUrl, string $image2ObsUrl ): ResponseInterface
    {
        return $this->compareFace(ImageTypes::OBS_URL, $image1ObsUrl, $image2ObsUrl);
    }

    /**
     * @param string $image1LocalFilePath
     * @param string $image2LocalFilePath
     *
     * @return ResponseInterface
     */
    public function compareFaceByLocalFile( string $image1LocalFilePath, string $image2LocalFilePath ): ResponseInterface
    {
        $uri = sprintf(FrsPaths::FACE_COMPARE, $this->projectId);

        $body['multipart'][] = [
            'name'     => 'image1_file',
            'contents' => fopen($image1LocalFilePath, 'rb'),
        ];
        $body['multipart'][] = [
            'name'     => 'image2_file',
            'contents' => fopen($image2LocalFilePath, 'rb'),
        ];

        return $this->accessService->postMultipartFormData($uri,$body);
    }

    /**
     * @param string $imageType
     * @param string $image1
     * @param string $image2
     *
     * @return ResponseInterface
     */
    private function compareFace( string $imageType, string $image1, string $image2 ): ResponseInterface
    {
        $uri = sprintf(FrsPaths::FACE_COMPARE, $this->projectId);

        $body = [];

        switch ( $imageType ) {
            case ImageTypes::BASE64:
                $body['image1_base64'] = $image1;
                $body['image2_base64'] = $image2;
                break;
            case ImageTypes::OBS_URL:
                $body['image1_url'] = $image1;
                $body['image2_url'] = $image2;
                break;
            default:
                throw new InvalidArgumentException("imageType must be one of base64  / obs_url ,$imageType given");
        }

        return $this->accessService->post($uri,$body);
    }
}