<?php

namespace HuaweiFrsSdk\Tests;


use HuaweiFrsSdk\Client\Param\AuthInfo;
use HuaweiFrsSdk\Client\FrsClient;
use HuaweiFrsSdk\Client\Param\ExternalFieldDefinitions;
use HuaweiFrsSdk\Client\Param\ExternalFieldDefinition;
use HuaweiFrsSdk\Client\Param\FieldTypes;
use PHPUnit_Framework_TestCase;

class FaceSetServiceTest extends PHPUnit_Framework_TestCase
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
    private $tempFaceSetName;

    public function setUp()
    {
        $this->ak = getenv('HUAWEI_FRS_AK') ;
        $this->sk = getenv('HUAWEI_FRS_SK') ;
        $this->endpoint = getenv('HUAWEI_FRS_ENDPOINT') ;

        $this->authInfo = new AuthInfo($this->endpoint,$this->ak,$this->sk);

        $this->projectId = getenv('HUAWEI_FRS_PROJECT_ID');
        $this->faceSetName = getenv('HUAWEI_FRS_FACE_SET_NAME');

        $this->faceId = getenv('HUAWEI_FRS_SEARCH_FACE_ID');

        $this->tempFaceSetName = getenv('HUAWEI_FRS_TEMP_FACE_SET_NAME');
    }

    public function testGetAllFaceSets(): void
    {
        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $response = $frsClient->getFaceSetService()->getAllFaceSets();

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
        echo '>>>>>>>>>>>>' .PHP_EOL.var_export($response->getBody()->getContents(),true).PHP_EOL.'<<<<<<<<<<<<'.PHP_EOL;

        $this->assertEquals(200,$response->getStatusCode());
        $this->assertGreaterThanOrEqual(0,count($response->getResult()->getFaceSetsInfo()));
    }

    public function testGetFaceSet(): void
    {
        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $response = $frsClient->getFaceSetService()->getFaceSet($this->faceSetName);

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
        echo '>>>>>>>>>>>>' .PHP_EOL.var_export($response->getBody()->getContents(),true).PHP_EOL.'<<<<<<<<<<<<'.PHP_EOL;

        $this->assertEquals(200,$response->getStatusCode());
        $this->assertEquals($this->faceSetName,$response->getResult()->getFaceSetInfo()->getName());
    }

    public function testCreateFaceSet(): void
    {
        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $externalFields = new ExternalFieldDefinitions([
            new ExternalFieldDefinition('etf_01',FieldTypes::STRING),
            new ExternalFieldDefinition('etf_02',FieldTypes::DOUBLE),
            new ExternalFieldDefinition('etf_03',FieldTypes::BOOLEAN),
            new ExternalFieldDefinition('etf_04',FieldTypes::FLOAT),
            new ExternalFieldDefinition('etf_05',FieldTypes::INTEGER),
            new ExternalFieldDefinition('etf_06',FieldTypes::LONG),
        ]);
        $response = $frsClient->getFaceSetService()->createFaceSet($this->tempFaceSetName,100000,$externalFields);

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
        echo '>>>>>>>>>>>>' .PHP_EOL.var_export($response->getBody()->getContents(),true).PHP_EOL.'<<<<<<<<<<<<'.PHP_EOL;

        $this->assertEquals(200,$response->getStatusCode());
        $this->assertEquals($this->tempFaceSetName,$response->getResult()->getFaceSetInfo()->getName());
        $this->assertEquals(0,$response->getResult()->getFaceSetInfo()->getNumber());
    }

    public function testDeleteFaceSet(): void
    {
        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $response = $frsClient->getFaceSetService()->deleteFaceSet($this->tempFaceSetName);

        // {
        //    "face_set_name": "face_sets_ut_01"
        //}
        echo '>>>>>>>>>>>>' .PHP_EOL.var_export($response->getBody()->getContents(),true).PHP_EOL.'<<<<<<<<<<<<'.PHP_EOL;

        $this->assertEquals(200,$response->getStatusCode());
        $this->assertEquals($this->tempFaceSetName,$response->getResult()->getFaceSetName());
    }
}