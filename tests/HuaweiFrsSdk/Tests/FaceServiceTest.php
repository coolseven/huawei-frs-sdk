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
}