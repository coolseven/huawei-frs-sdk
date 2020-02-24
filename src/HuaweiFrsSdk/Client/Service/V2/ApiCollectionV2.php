<?php


namespace HuaweiFrsSdk\Client\Service\V2;


use HuaweiFrsSdk\Access\FrsAccess;

class ApiCollectionV2
{
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
     * SearchService constructor.
     *
     * @param FrsAccess $accessService
     * @param string    $projectId
     */
    public function __construct( FrsAccess $accessService, string $projectId)
    {
        $this->searchService = new SearchService($accessService, $projectId);
        $this->faceSetService = new FaceSetService($accessService, $projectId);
        $this->faceService = new FaceService($accessService, $projectId);
        $this->detectService = new DetectService($accessService, $projectId);
        $this->compareService = new CompareService($accessService, $projectId);
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
}