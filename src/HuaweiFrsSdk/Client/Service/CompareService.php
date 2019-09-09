<?php

namespace HuaweiFrsSdk\Client\Service;


use HuaweiFrsSdk\Access\FrsAccess;
use HuaweiFrsSdk\Common\FrsPaths;
use HuaweiFrsSdk\Common\ImageTypes;
use InvalidArgumentException;

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

    public function compareFaceByBase64( string $image1Base64, string $image2Base64 )
    {
        return $this->compareFace(ImageTypes::BASE64, $image1Base64, $image2Base64);
    }

    public function compareFaceByObsUrl( string $image1ObsUrl, string $image2ObsUrl )
    {
        return $this->compareFace(ImageTypes::OBS_URL, $image1ObsUrl, $image2ObsUrl);
    }

    public function compareFaceByLocalFile( string $image1LocalFilePath, string $image2LocalFilePath )
    {
        // TODO
    }

    private function compareFace( string $imageType, string $image1, string $image2 )
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
                throw new InvalidArgumentException("imageType must be one of image_base64  / image_url ,but $imageType provided");
        }

        return $this->accessService->post($uri,$body);
    }
}