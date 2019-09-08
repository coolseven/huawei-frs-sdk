<?php
/**
 * PROJECT: huawei-frs-sdk
 * FILENAME: FrsClient.php
 * HOMEPAGE: https://github.com/coolseven/huaweicloud-sdk-php-frs
 */

namespace HuaweiFrsSdk\Client\Service;


use HuaweiFrsSdk\Access\FrsAccess;
use HuaweiFrsSdk\Access\HttpClient\Options;
use HuaweiFrsSdk\Client\Param\AuthInfo;

class FrsClient
{
    /**
     * @var AuthInfo
     */
    private $authInfo;
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
     * FrsClient constructor.
     *
     * @param AuthInfo $authInfo
     * @param string   $projectId
     * @param int      $connectionTimeout
     */
    public function __construct( AuthInfo $authInfo, string $projectId, int $connectionTimeout = Options::DEFAULT_CONNECTION_TIMEOUT_IN_SECONDS)
    {
        $this->authInfo = $authInfo;
        $this->projectId = $projectId;

        $this->frsAccess = new FrsAccess($this->authInfo, $connectionTimeout);
        $this->initServices();
    }

    private function initServices() : void
    {
        $this->searchService = new SearchService($this->frsAccess, $this->projectId);
    }

    /**
     * @return SearchService
     */
    public function getSearchService() : SearchService
    {
        return $this->searchService;
    }
}