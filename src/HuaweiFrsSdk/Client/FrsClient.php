<?php

namespace HuaweiFrsSdk\Client;


use HuaweiFrsSdk\Access\FrsAccess;
use HuaweiFrsSdk\Access\HttpClient\Options;
use HuaweiFrsSdk\Client\Param\AuthInfo;
use HuaweiFrsSdk\Client\Service\CompareService;
use HuaweiFrsSdk\Client\Service\DetectService;
use HuaweiFrsSdk\Client\Service\FaceService;
use HuaweiFrsSdk\Client\Service\FaceSetService;
use HuaweiFrsSdk\Client\Service\LiveDetectService;
use HuaweiFrsSdk\Client\Service\SearchService;
use HuaweiFrsSdk\Client\Service\V2\ApiCollectionV2;

class FrsClient
{
    /**
     * @var string
     */
    private $projectId;
    /**
     * @var FrsAccess
     */
    private $frsAccess;
    /**
     * @var SearchService
     */
    private $searchService;
    /**
     * @var FaceSetService
     */
    private $faceSetService;
    /**
     * @var FaceService
     */
    private $faceService;
    /**
     * @var DetectService
     */
    private $detectService;
    /**
     * @var CompareService
     */
    private $compareService;
    /**
     * @var LiveDetectService
     */
    private $liveDetectService;
    /**
     * @var ApiCollectionV2
     */
    private $apiCollectionV2;

    /**
     * FrsClient constructor.
     *
     * @param AuthInfo $authInfo
     * @param string   $projectId
     * @param int      $connectionTimeout
     */
    public function __construct( AuthInfo $authInfo, string $projectId, int $connectionTimeout = Options::DEFAULT_CONNECTION_TIMEOUT_IN_SECONDS)
    {
        $this->projectId = $projectId;

        $this->frsAccess = new FrsAccess($authInfo, $connectionTimeout);

        $this->initServices();
    }

    private function initServices() : void
    {
        $this->searchService = new SearchService($this->frsAccess, $this->projectId);
        $this->faceSetService = new FaceSetService($this->frsAccess, $this->projectId);
        $this->faceService = new FaceService($this->frsAccess, $this->projectId);
        $this->detectService = new DetectService($this->frsAccess, $this->projectId);
        $this->compareService = new CompareService($this->frsAccess, $this->projectId);
        $this->liveDetectService = new LiveDetectService($this->frsAccess, $this->projectId);

        $this->apiCollectionV2 = new ApiCollectionV2($this->frsAccess, $this->projectId);
    }

    /**
     * @return SearchService
     */
    public function getSearchService() : SearchService
    {
        return $this->searchService;
    }

    public function getFaceSetService(): FaceSetService
    {
        return $this->faceSetService;
    }

    public function getFaceService(): FaceService
    {
        return $this->faceService;
    }

    /**
     * @return DetectService
     */
    public function getDetectService() : DetectService
    {
        return $this->detectService;
    }

    /**
     * @return CompareService
     */
    public function getCompareService() : CompareService
    {
        return $this->compareService;
    }

    /**
     * @return LiveDetectService
     */
    public function getLiveDetectService() : LiveDetectService
    {
        return $this->liveDetectService;
    }

    /**
     * @return ApiCollectionV2
     */
    public function getApiCollectionV2(): ApiCollectionV2
    {
        return $this->apiCollectionV2;
    }
}