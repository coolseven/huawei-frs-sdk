<?php


namespace HuaweiFrsSdk\Client\Service\V2;


use HuaweiFrsSdk\Access\FrsAccess;
use HuaweiFrsSdk\Access\HttpResponse\Face\AddFaceResponse;
use HuaweiFrsSdk\Access\HttpResponse\Face\GetFaceResponse;
use HuaweiFrsSdk\Client\Param\ExternalFields;
use HuaweiFrsSdk\Common\FrsPathsV2;
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
        $uri = sprintf(FrsPathsV2::FACE_GET_RANGE, $this->projectId, $faceSetName, $offset, $limit);

        return $this->accessService->get($uri);
    }

    public function getFace(string $faceSetName, string $faceId): GetFaceResponse
    {
        $uri = sprintf(FrsPathsV2::FACE_GET_ONE, $this->projectId, $faceSetName, $faceId);

        $response = $this->accessService->get($uri);

        return new GetFaceResponse($response);
    }

    public function addFaceByBase64(
        string $faceSetName,
        string $imageBase64,
        string $externalImageId = '',
        ExternalFields $externalFields = null
    ) : AddFaceResponse
    {
        return $this->addFace($faceSetName,ImageTypes::BASE64,$imageBase64,$externalImageId,$externalFields);
    }

    public function addFaceByObsUrl(
        string $faceSetName,
        string $imageObsUrl,
        string $externalImageId = '',
        ExternalFields $externalFields = null
    ) : AddFaceResponse
    {
        return $this->addFace($faceSetName,ImageTypes::OBS_URL,$imageObsUrl,$externalImageId,$externalFields);
    }

    public function addFaceByLocalFile(
        string $faceSetName,
        string $localFilePath,
        string $externalImageId = '',
        ExternalFields $externalFields = null
    ): AddFaceResponse
    {
        $uri = sprintf(FrsPathsV2::FACE_ADD, $this->projectId, $faceSetName);

        if (!empty($externalImageId)) {
            $body['multipart'][] = [
               'name' => 'external_image_id',
               'contents' => $externalImageId,
            ];
        }

        if ($externalFields !== null) {
            $body['multipart'][] = [
                'name' => 'external_fields',
                'contents' => \GuzzleHttp\json_encode($externalFields->getExternalFields()),
            ];
        }

        $body['multipart'][] = [
            'name'     => 'image_file',
            'contents' => fopen($localFilePath, 'rb'),
        ];

        $response = $this->accessService->postMultipartFormData($uri,$body);

        return new AddFaceResponse($response);
    }

    public function updateFaceByFaceId(
        string $faceSetName,
        string $faceId,
        string $externalImageId = '',
        ExternalFields $externalFields = null
    ) : ResponseInterface
    {
        $uri = sprintf(FrsPathsV2::FACE_UPDATE, $this->projectId, $faceSetName);

        $body['face_id'] = $faceId;
        if (!empty($externalImageId)) {
            $body['external_image_id'] = $externalImageId;
        }

        if ($externalFields !== null) {
            $body['external_fields'] = $externalFields->getExternalFields();
        }

        return $this->accessService->put($uri,$body);
    }

    public function deleteFaceByFaceId(string $faceSetName,string $faceId) : ResponseInterface
    {
        $uri = sprintf(FrsPathsV2::FACE_DELETE_BY_FACE_ID, $this->projectId, $faceSetName, $faceId);

        return $this->accessService->delete($uri);
    }

    public function deleteFaceByExternalImageId(string $faceSetName,string $externalImageId) : ResponseInterface
    {
        $uri = sprintf(FrsPathsV2::FACE_DELETE_BY_EXTERNAL_IMAGE_ID, $this->projectId, $faceSetName, $externalImageId);

        return $this->accessService->delete($uri);
    }

    public function deleteFaceByExternalField( string $faceSetName, string $externalFieldKey, string $externalFieldValue) : ResponseInterface
    {
        $uri = sprintf(FrsPathsV2::FACE_DELETE_BY_EXTERNAL_FIELD, $this->projectId, $faceSetName, $externalFieldKey, $externalFieldValue);

        return $this->accessService->delete($uri);
    }

    public function batchDeleteFacesByFilter( string $faceSetName, string $filter ): ResponseInterface
    {
        $uri = sprintf(FrsPathsV2::FACE_BATCH_DELETE_BY_FILTER, $this->projectId, $faceSetName );

        $body['filter'] = $filter;

        return $this->accessService->delete($uri,$body);
    }

    private function addFace(
        string $faceSetName,
        string $imageType,
        string $image,
        string $externalImageId = '',
        ExternalFields $externalFields = null
    ): AddFaceResponse
    {
        $uri = sprintf(FrsPathsV2::FACE_ADD, $this->projectId, $faceSetName);

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

        if (!empty($externalImageId)) {
            $body['external_image_id'] = $externalImageId;
        }

        if ($externalFields !== null) {
            $body['external_fields'] = $externalFields->getExternalFields();
        }

        $response = $this->accessService->post($uri,$body);

        return new AddFaceResponse($response);
    }
}