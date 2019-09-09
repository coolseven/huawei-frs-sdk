<?php

namespace HuaweiFrsSdk\Client;


use HuaweiFrsSdk\Access\FrsAccess;
use HuaweiFrsSdk\Access\HttpClient\Options;
use HuaweiFrsSdk\Client\Param\AuthInfo;
use HuaweiFrsSdk\Client\Service\FaceService;
use HuaweiFrsSdk\Client\Service\FaceSetService;
use HuaweiFrsSdk\Client\Service\SearchService;

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
}