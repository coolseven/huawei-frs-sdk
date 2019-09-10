<?php

namespace HuaweiFrsSdk\Client\Service;


use HuaweiFrsSdk\Access\FrsAccess;
use HuaweiFrsSdk\Client\Param\ExternalFieldDefinitions;
use HuaweiFrsSdk\Common\FrsPaths;
use Psr\Http\Message\ResponseInterface;

class FaceSetService
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

    public function getAllFaceSets(): ResponseInterface
    {
        $uri = sprintf(FrsPaths::FACE_SET_GET_ALL, $this->projectId);

        return $this->accessService->get($uri);
    }

    public function getFaceSet(string $faceSetName): ResponseInterface
    {
        $uri = sprintf(FrsPaths::FACE_SET_GET_ONE, $this->projectId, $faceSetName);

        return $this->accessService->get($uri);
    }

    public function createFaceSet(
        string $faceSetName,
        int $faceSetCapacity = 100000,
        ExternalFieldDefinitions $createExternalFields = null
    ): ResponseInterface
    {
        $uri = sprintf(FrsPaths::FACE_SET_CREATE, $this->projectId);

        $body['face_set_name'] = $faceSetName;
        $body['face_set_capacity'] = $faceSetCapacity;
        if (null !== $createExternalFields && count($createExternalFields->getExternalFields())) {
            $body['external_fields'] = $createExternalFields->getExternalFields();
        }

        return $this->accessService->post($uri,$body);
    }

    public function deleteFaceSet(string $faceSetName): ResponseInterface
    {
        $uri = sprintf(FrsPaths::FACE_SET_DELETE, $this->projectId, $faceSetName);

        return $this->accessService->delete($uri);
    }

}