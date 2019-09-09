<?php

namespace HuaweiFrsSdk\Tests;


use HuaweiFrsSdk\Client\Param\AuthInfo;
use HuaweiFrsSdk\Client\FrsClient;
use PHPUnit_Framework_TestCase;

class FaceServiceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var string
     */
    private $ak;
    /**
     * @var string
     */
    private $sk;
    /**
     * @var string
     */
    private $endpoint;

    /**
     * @var AuthInfo
     */
    private $authInfo;
    /**
     * @var string
     */
    private $projectId;
    /**
     * @var string
     */
    private $faceSetName;
    /**
     * @var string
     */
    private $faceId;
    /**
     * @var string
     */
    private $externalImageId;

    public function setUp()
    {
        require_once __DIR__.'/../../bootstrap.php';

        $this->ak = getenv('HUAWEI_FRS_AK') ;
        $this->sk = getenv('HUAWEI_FRS_SK') ;
        $this->endpoint = getenv('HUAWEI_FRS_ENDPOINT') ;

        $this->authInfo = new AuthInfo($this->endpoint,$this->ak,$this->sk);

        $this->projectId = getenv('HUAWEI_FRS_PROJECT_ID');
        $this->faceSetName = getenv('HUAWEI_FRS_FACE_SET_NAME');
        $this->faceId = getenv('HUAWEI_FRS_SEARCH_FACE_ID');
        $this->externalImageId = getenv('HUAWEI_FRS_EXTERNAL_IMAGE_ID');
    }

    public function testGetFaces(): void
    {
        $offset = 0;
        $limit = 2;

        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $response = $frsClient->getFaceService()->getFaces($this->faceSetName,$offset,$limit);

        // {
        //    "face_set_id": "ER4HtVIY",
        //    "face_set_name": "faceset_test",
        //    "faces": [
        //        {
        //            "face_id": "RG16TGCu",
        //            "external_image_id": "40f0fdce-7797-46e5-9baa-fc11c5cc5d13",
        //            "bounding_box": {
        //                "width": 97,
        //                "top_left_x": 49,
        //                "top_left_y": 60,
        //                "height": 97
        //            },
        //            "external_fields": {
        //                "number": "",
        //                "id": "40f0fdce-7797-46e5-9baa-fc11c5cc5d13",
        //                "timestamp": 1562327352
        //            }
        //        },
        //        {
        //            "face_id": "gq8yLuDe",
        //            "external_image_id": "40f12c47-70b2-49fa-8f90-592c1bff7e89",
        //            "bounding_box": {
        //                "width": 68,
        //                "top_left_x": 36,
        //                "top_left_y": 81,
        //                "height": 68
        //            },
        //            "external_fields": {
        //                "number": "",
        //                "id": "40f12c47-70b2-49fa-8f90-592c1bff7e89",
        //                "timestamp": 1562327352
        //            }
        //        }
        //    ]
        //}
        echo '>>>>>>>>>>>>' .PHP_EOL.var_export($response->getBody()->getContents(),true).PHP_EOL.'<<<<<<<<<<<<'.PHP_EOL;

        $this->assertEquals(200,$response->getStatusCode());
    }


    public function testGetFace(): void
    {
        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $response = $frsClient->getFaceService()->getFace($this->faceSetName,'RG16TGCu');

        // {
        //    "face_set_id": "ER4HtVIY",
        //    "face_set_name": "faceset_test",
        //    "faces": [
        //        {
        //            "face_id": "RG16TGCu",
        //            "external_image_id": "40f0fdce-7797-46e5-9baa-fc11c5cc5d13",
        //            "bounding_box": {
        //                "width": 97,
        //                "top_left_x": 49,
        //                "top_left_y": 60,
        //                "height": 97
        //            },
        //            "external_fields": {
        //                "number": "",
        //                "id": "40f0fdce-7797-46e5-9baa-fc11c5cc5d13",
        //                "timestamp": 1562327352
        //            }
        //        }
        //    ]
        //}
        echo '>>>>>>>>>>>>' .PHP_EOL.var_export($response->getBody()->getContents(),true).PHP_EOL.'<<<<<<<<<<<<'.PHP_EOL;

        $this->assertEquals(200,$response->getStatusCode());
    }

    public function testAddFaceByBase64() : void
    {
        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $imageFilePath = __DIR__.'/images/donald_trump.jpeg';

        $imageBase64 = base64_encode(file_get_contents($imageFilePath));

        $externalImageId = md5(file_get_contents($imageFilePath));

        $response = $frsClient->getFaceService()->addFaceByBase64($this->faceSetName,$imageBase64,$externalImageId);

        echo '>>>>>>>>>>>>' .PHP_EOL.var_export($response->getBody()->getContents(),true).PHP_EOL.'<<<<<<<<<<<<'.PHP_EOL;

        $this->assertEquals(200,$response->getStatusCode());
    }

    public function updateFaceByFaceId() : void
    {
        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $response = $frsClient->getFaceService()->updateFaceByFaceId($this->faceSetName,$this->faceId,$this->externalImageId);

        echo '>>>>>>>>>>>>' .PHP_EOL.var_export($response->getBody()->getContents(),true).PHP_EOL.'<<<<<<<<<<<<'.PHP_EOL;

        $this->assertEquals(200,$response->getStatusCode());
    }

    public function testDeleteFaceByFaceId() : void
    {
        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $response = $frsClient->getFaceService()->deleteFaceByFaceId($this->faceSetName,$this->faceId);

        echo '>>>>>>>>>>>>' .PHP_EOL.var_export($response->getBody()->getContents(),true).PHP_EOL.'<<<<<<<<<<<<'.PHP_EOL;

        $this->assertEquals(200,$response->getStatusCode());
    }

    public function testDeleteFaceByExternalImageId() : void
    {
        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $response = $frsClient->getFaceService()->deleteFaceByExternalImageId($this->faceSetName,$this->externalImageId);

        echo '>>>>>>>>>>>>' .PHP_EOL.var_export($response->getBody()->getContents(),true).PHP_EOL.'<<<<<<<<<<<<'.PHP_EOL;

        $this->assertEquals(200,$response->getStatusCode());
    }

    public function testBatchDeleteFaces() : void
    {
        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $response = $frsClient->getFaceService()->batchDeleteFacesByFilter($this->faceSetName,'age:[20 TO 30]');

        echo '>>>>>>>>>>>>' .PHP_EOL.var_export($response->getBody()->getContents(),true).PHP_EOL.'<<<<<<<<<<<<'.PHP_EOL;

        $this->assertEquals(200,$response->getStatusCode());
    }
}