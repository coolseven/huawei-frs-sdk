<?php

namespace HuaweiFrsSdk\Tests\V1;


use Exception;
use HuaweiFrsSdk\Client\Param\AuthInfo;
use HuaweiFrsSdk\Client\FrsClient;
use HuaweiFrsSdk\Client\Param\ExternalField;
use HuaweiFrsSdk\Client\Param\ExternalFields;
use HuaweiFrsSdk\Tests\BaseTestCase;

class FaceServiceTest extends BaseTestCase
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
    public function testAddFaceByBase64() : void
    {
        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $faceSetName = $this->randomFaceSetName();

        $this->createV1FaceSet($frsClient,$faceSetName);

        $imageFilePath = __DIR__.'/../images/donald_trump.jpeg';

        $imageBase64 = base64_encode(file_get_contents($imageFilePath));

        $externalImageId = md5(file_get_contents($imageFilePath));

        $response = $frsClient
            ->getFaceService()
            ->addFaceByBase64($faceSetName,$imageBase64,$externalImageId);

        // {
        //    "face_set_id": "ER4HtVIY",
        //    "face_set_name": "faceset_test",
        //    "faces": [
        //        {
        //            "face_id": "6OvUvI9k",
        //            "external_image_id": "972c5c973b3ca00e169d916eec55c121",
        //            "bounding_box": {
        //                "width": 225,
        //                "top_left_x": 153,
        //                "top_left_y": 163,
        //                "height": 225
        //            },
        //            "external_fields": {}
        //        }
        //    ]
        //}

        $this->assertEquals(200,$response->getStatusCode());
        $this->assertEquals($faceSetName,$response->getResult()->getFaceSetName());
        $this->assertEquals($externalImageId,( $response->getResult()->getFaces()[0])->getExternalImageId());

        $this->deleteV1FaceSet($frsClient,$faceSetName);
    }


    /**
     * @throws Exception
     */
    public function testAddFaceByLocalFile(): void
    {
        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $faceSetName = $this->randomFaceSetName();

        $this->createV1FaceSet($frsClient,$faceSetName);

        $imageFilePath = __DIR__.'/../images/donald_trump.jpeg';

        $externalImageId = md5(file_get_contents($imageFilePath));

        $response = $frsClient
            ->getFaceService()
            ->addFaceByLocalFile(
                $faceSetName,
                $imageFilePath,
                $externalImageId,
                new ExternalFields([
                    new ExternalField('number', 90),
                    new ExternalField('id', 'id_01'),
                    new ExternalField('timestamp', 123456),
                ])
            )
        ;

        // {
        //    "face_set_id": "ER4HtVIY",
        //    "face_set_name": "faceset_test",
        //    "faces": [
        //        {
        //            "face_id": "tv9Mn01C",
        //            "external_image_id": "972c5c973b3ca00e169d916eec55c121",
        //            "bounding_box": {
        //                "width": 225,
        //                "top_left_x": 153,
        //                "top_left_y": 163,
        //                "height": 225
        //            },
        //            "external_fields": {
        //                "number": 90,
        //                "id": "id_01",
        //                "timestamp": 123456
        //            }
        //        }
        //    ]
        //}

        $this->assertEquals(200,$response->getStatusCode());
        $this->assertEquals($faceSetName,$response->getResult()->getFaceSetName());
        $this->assertEquals($externalImageId,( $response->getResult()->getFaces()[0])->getExternalImageId());

        $this->deleteV1FaceSet($frsClient,$faceSetName);
    }

    /**
     * @throws Exception
     */
    public function testGetFaces(): void
    {
        $offset = 0;
        $limit = 2;

        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $faceSetName = $this->randomFaceSetName();

        $this->createV1FaceSet($frsClient,$faceSetName);

        $this->addTestFaceByBase64V1($frsClient,$faceSetName);

        sleep(2);

        $response = $frsClient
            ->getFaceService()
            ->getFaces($faceSetName,$offset,$limit);

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

        $this->assertEquals(200,$response->getStatusCode());

        $body = json_decode($response->getBody()->getContents(),true);
        $this->assertArrayHasKey('faces',$body);
        $this->assertGreaterThan(0,count($body['faces']));

        $this->deleteV1FaceSet($frsClient,$faceSetName);
    }

    /**
     * @throws Exception
     */
    public function testGetFace(): void
    {
        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $faceSetName = $this->randomFaceSetName();

        $this->createV1FaceSet($frsClient,$faceSetName);

        $faceId = ($this->addTestFaceByBase64V1($frsClient,$faceSetName)
                      ->getResult()
                      ->getFaces()[0]
        )->getFaceId();

        sleep(2);

        $response = $frsClient
            ->getFaceService()
            ->getFace($faceSetName,$faceId);

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

        $this->assertEquals(200,$response->getStatusCode());
        $this->assertEquals($faceId,$response->getResult()->getFace()->getFaceId());

        $this->deleteV1FaceSet($frsClient,$faceSetName);
    }

    /**
     * @throws Exception
     */
    public function testUpdateFaceByFaceId() : void
    {
        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $faceSetName = $this->randomFaceSetName();

        $this->createV1FaceSet($frsClient,$faceSetName);

        $faceId = ($this->addTestFaceByBase64V1($frsClient,$faceSetName)
                       ->getResult()
                       ->getFaces()[0]
        )->getFaceId();

        sleep(2);

        $response = $frsClient
            ->getFaceService()
            ->updateFaceByFaceId(
            $faceSetName,
            $faceId,
            $this->randomExternalImageId(),
            new ExternalFields([
                new ExternalField('number',90),
                new ExternalField('id','id_01'),
                new ExternalField('timestamp',123456),
            ])
        );

        // {
        //    "face_number": 1,
        //    "face_set_name": "faceset_test",
        //    "face_set_id": "ER4HtVIY"
        //}

        $this->assertEquals(200,$response->getStatusCode());

        $this->deleteV1FaceSet($frsClient,$faceSetName);
    }

    /**
     * @throws Exception
     */
    public function testDeleteFaceByFaceId() : void
    {
        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $faceSetName = $this->randomFaceSetName();

        $this->createV1FaceSet($frsClient,$faceSetName);

        $faceId = ($this->addTestFaceByBase64V1($frsClient,$faceSetName)
                       ->getResult()
                       ->getFaces()[0]
        )->getFaceId();

        sleep(2);

        $response = $frsClient
            ->getFaceService()
            ->deleteFaceByFaceId($faceSetName,$faceId);

        // {
        //    "face_number": 1,
        //    "face_set_name": "faceset_test",
        //    "face_set_id": "ER4HtVIY"
        //}

        $this->assertEquals(200,$response->getStatusCode());

        $this->deleteV1FaceSet($frsClient,$faceSetName);
    }

    /**
     * @throws Exception
     */
    public function testDeleteFaceByExternalImageId() : void
    {
        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $faceSetName = $this->randomFaceSetName();

        $this->createV1FaceSet($frsClient,$faceSetName);

        $externalImageId = ($this->addTestFaceByBase64V1($frsClient,$faceSetName)
                                ->getResult()
                                ->getFaces()[0]
        )->getExternalImageId();

        sleep(2);

        $response = $frsClient
            ->getFaceService()
            ->deleteFaceByExternalImageId($faceSetName,$externalImageId);

        // {
        //    "face_number": 1,
        //    "face_set_name": "faceset_test",
        //    "face_set_id": "ER4HtVIY"
        //}

        $this->assertEquals(200,$response->getStatusCode());

        $this->deleteV1FaceSet($frsClient,$faceSetName);
    }

    /**
     * @throws Exception
     */
    public function testBatchDeleteFaces() : void
    {
        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $faceSetName = $this->randomFaceSetName();

        $this->createV1FaceSet($frsClient,$faceSetName);

        $imageFilePath = __DIR__.'/../images/donald_trump.jpeg';

        $externalImageId = md5(file_get_contents($imageFilePath));

        $frsClient
            ->getFaceService()
            ->addFaceByLocalFile(
                $faceSetName,
                $imageFilePath,
                $externalImageId,
                new ExternalFields([
                    new ExternalField('number', 90),
                    new ExternalField('id', 'id_01'),
                    new ExternalField('timestamp', 123456),
                ])
            )
        ;

        sleep(2);

        $response = $frsClient
            ->getFaceService()
            ->batchDeleteFacesByFilter($faceSetName,'number:[89 TO 91]');

        // {
        //    "face_number": 1,
        //    "face_set_name": "faceset_test",
        //    "face_set_id": "ER4HtVIY"
        //}

        $this->assertEquals(200,$response->getStatusCode());

        $this->deleteV1FaceSet($frsClient,$faceSetName);
    }
}