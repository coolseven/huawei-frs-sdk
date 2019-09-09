<?php


namespace HuaweiFrsSdk\Client\Service;


use HuaweiFrsSdk\Access\FrsAccess;
use HuaweiFrsSdk\Client\Param\ExternalFields;
use HuaweiFrsSdk\Common\FrsPaths;
use HuaweiFrsSdk\Common\ImageTypes;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;

class FaceService
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

    public function getFaces(string $faceSetName, int $offset, int $limit): ResponseInterface
    {
        $uri = sprintf(FrsPaths::FACE_GET_RANGE, $this->projectId, $faceSetName, $offset, $limit);

        return $this->accessService->get($uri);
    }

    public function getFace(string $faceSetName, string $faceId): ResponseInterface
    {
        $uri = sprintf(FrsPaths::FACE_GET_ONE, $this->projectId, $faceSetName, $faceId);

        return $this->accessService->get($uri);
    }

    public function addFaceByBase64(
        string $faceSetName,
        string $imageBase64,
        string $externalImageId = '',
        ExternalFields $externalFields = null
    )
    {
        return $this->addFace($faceSetName,ImageTypes::BASE64,$imageBase64,$externalImageId,$externalFields);
    }

    private function addFace(string $faceSetName, string $imageType, string $image, string $externalImageId, ExternalFields $externalFields)
    {
        $uri = sprintf(FrsPaths::FACE_ADD, $this->projectId, $faceSetName);

        $body = [];

        switch ( $imageType ) {
            case ImageTypes::BASE64:
                $body['image_base64'] = $image;
                break;
            case ImageTypes::OBS_URL:
                $body['image_url'] = $image;
                break;
            default:
                throw new InvalidArgumentException("imageType must be one of image_base64 / face_id / image_url ,but $imageType provided");
        }

        $body['external_image_id'] = $externalImageId;
        $body['external_fields'] = $externalFields->getExternalFields();

        return $this->accessService->post($uri,$body);
    }
}