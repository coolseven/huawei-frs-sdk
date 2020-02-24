<?php

namespace HuaweiFrsSdk\Tests\V1;


use Exception;
use HuaweiFrsSdk\Client\Param\AuthInfo;
use HuaweiFrsSdk\Client\FrsClient;
use HuaweiFrsSdk\Tests\BaseTestCase;

class FaceSetServiceTest extends BaseTestCase
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

    public function setUp()
    {
        $this->ak = getenv('V1_HUAWEI_FRS_AK') ;
        $this->sk = getenv('V1_HUAWEI_FRS_SK') ;
        $this->endpoint = getenv('V1_HUAWEI_FRS_ENDPOINT') ;

        $this->authInfo = new AuthInfo($this->endpoint,$this->ak,$this->sk);

        $this->projectId = getenv('V1_HUAWEI_FRS_PROJECT_ID');
    }

    /**
     * @throws Exception
     */
    public function testCreateFaceSet(): void
    {
        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $faceSetName = $this->randomFaceSetName();

        $response = $this->createV1FaceSet($frsClient,$faceSetName);
        // {
        //    "face_set_info": {
        //        "face_number": 0,
        //        "face_set_id": "5PtLHVrh",
        //        "face_set_name": "face_sets_ut_01",
        //        "create_date": "2019-09-09 11:33:11",
        //        "face_set_capacity": 100000,
        //        "external_fields": {
        //            "etf_01": {
        //                "type": "string"
        //            },
        //            "etf_02": {
        //                "type": "double"
        //            },
        //            "etf_03": {
        //                "type": "boolean"
        //            },
        //            "etf_04": {
        //                "type": "float"
        //            },
        //            "etf_05": {
        //                "type": "integer"
        //            },
        //            "etf_06": {
        //                "type": "long"
        //            }
        //        }
        //    }
        //}

        $this->assertEquals(200,$response->getStatusCode());
        $this->assertEquals($faceSetName,$response->getResult()->getFaceSetInfo()->getName());
        $this->assertEquals(0,$response->getResult()->getFaceSetInfo()->getNumber());
        $this->assertGreaterThanOrEqual(0,$response->getResult()->getFaceSetInfo()->getExternalFieldDefinitions()->getExternalFieldDefinitions());


        $this->deleteV1FaceSet($frsClient,$faceSetName);
    }

    /**
     * @throws Exception
     */
    public function testGetAllFaceSets(): void
    {
        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $faceSetName = $this->randomFaceSetName();

        $this->createV1FaceSet($frsClient,$faceSetName);

        $response = $frsClient
            ->getFaceSetService()
            ->getAllFaceSets();

        // {
        //    "face_sets_info": [
        //        {
        //            "face_number": 66808,
        //            "face_set_id": "ER4HtVIY",
        //            "face_set_name": "faceset_test",
        //            "create_date": "2019-07-04 08:40:08",
        //            "face_set_capacity": 100000,
        //            "external_fields": {
        //                "number": {
        //                    "type": "integer"
        //                },
        //                "id": {
        //                    "type": "string"
        //                },
        //                "timestamp": {
        //                    "type": "long"
        //                }
        //            }
        //        }
        //    ]
        //}

        $this->assertEquals(200,$response->getStatusCode());
        $this->assertGreaterThanOrEqual(1,count($response->getResult()->getFaceSetsInfo()));

        $this->deleteV1FaceSet($frsClient,$faceSetName);
    }

    /**
     * @throws Exception
     */
    public function testGetFaceSet(): void
    {
        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $faceSetName = $this->randomFaceSetName();

        $this->createV1FaceSet($frsClient,$faceSetName);

        $response = $frsClient
            ->getFaceSetService()
            ->getFaceSet($faceSetName);

        // {
        //    "face_set_info": {
        //        "face_number": 66808,
        //        "face_set_id": "ER4HtVIY",
        //        "face_set_name": "faceset_test",
        //        "create_date": "2019-07-04 08:40:08",
        //        "face_set_capacity": 100000,
        //        "external_fields": {
        //            "number": {
        //                "type": "integer"
        //            },
        //            "id": {
        //                "type": "string"
        //            },
        //            "timestamp": {
        //                "type": "long"
        //            }
        //        }
        //    }
        //}

        $this->assertEquals(200,$response->getStatusCode());
        $this->assertEquals($faceSetName,$response->getResult()->getFaceSetInfo()->getName());

        $this->deleteV1FaceSet($frsClient,$faceSetName);
    }
}