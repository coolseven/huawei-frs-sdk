<?php
/**
 * PROJECT: huawei-frs-sdk
 * FILENAME: SearchServiceTest.php
 * HOMEPAGE: https://github.com/coolseven/huaweicloud-sdk-php-frs
 */

namespace HuaweiFrsSdk\Tests;


use function getenv;
use HuaweiFrsSdk\Client\Param\AuthInfo;
use HuaweiFrsSdk\Client\Service\FrsClient;

class SearchServiceTest extends \PHPUnit_Framework_TestCase
{
    private $ak;
    private $sk;
    private $endpoint;

    private $authInfo;
    private $projectId;
    private $faceSetName;
    private $faceId;

    public function setUp()
    {
        require_once __DIR__.'/../../bootstrap.php';

        $this->ak = getenv("HUAWEI_FRS_AK") ;
        $this->sk = getenv("HUAWEI_FRS_SK") ;
        $this->endpoint = getenv("HUAWEI_FRS_ENDPOINT") ;

        $this->authInfo = new AuthInfo($this->endpoint,$this->ak,$this->sk);

        $this->projectId = getenv('HUAWEI_FRS_PROJECT_ID');
        $this->faceSetName = getenv('HUAWEI_FACE_SET_NAME');
        $this->faceId = getenv('HUAWEI_FRS_SEARCH_FACE_ID');
    }

    public function testSearchByImageBase64()
    {
        $imageBase64 = base64_encode(file_get_contents(__DIR__.'/images/donald_trump.jpeg'));

        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $response = $frsClient->getSearchService()->searchFaceByBase64($this->faceSetName,$imageBase64,100);

        $this->assertEquals(200,$response->getHttpCode());
    }

    public function testSearchByFaceId()
    {
        $frsClient = new FrsClient($this->authInfo,$this->projectId);
        $response = $frsClient->getSearchService()->searchFaceByFaceId($this->faceSetName,$this->faceId,100);

        $this->assertEquals(200,$response->getHttpCode());
    }
}