<?php

namespace HuaweiFrsSdk\Tests\V1;


use Exception;
use HuaweiFrsSdk\Client\Param\AuthInfo;
use HuaweiFrsSdk\Client\FrsClient;
use HuaweiFrsSdk\Tests\BaseTestCase;

class SearchServiceTest extends BaseTestCase
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
    public function testSearchByImageBase64(): void
    {
        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $faceSetName = $this->randomFaceSetName();

        $this->createV1FaceSet($frsClient,$faceSetName);

        $this->addTestFaceByBase64V1($frsClient,$faceSetName);

        $imageBase64 = base64_encode(
            file_get_contents(__DIR__.'/../images/donald_trump.jpeg')
        );

        $response = $frsClient
            ->getSearchService()
            ->searchFaceByBase64($faceSetName,$imageBase64,100);

        // {
        //    "faces": [
        //        {
        //            "face_id": "XtCxmEgM",
        //            "external_image_id": "972c5c973b3ca00e169d916eec55c121",
        //            "bounding_box": {
        //                "width": 225,
        //                "top_left_x": 153,
        //                "top_left_y": 163,
        //                "height": 225
        //            },
        //            "similarity": 1
        //        },
        //        {
        //            "face_id": "iIOUoqKm",
        //            "external_image_id": "972c5c973b3ca00e169d916eec55c121",
        //            "bounding_box": {
        //                "width": 225,
        //                "top_left_x": 153,
        //                "top_left_y": 163,
        //                "height": 225
        //            },
        //            "similarity": 1
        //        }
        //    ]
        //}

        $this->assertEquals(200,$response->getStatusCode());
        $this->assertGreaterThanOrEqual(0,count($response->getResult()->getComplexFaces()));

        $this->deleteV1FaceSet($frsClient,$faceSetName);
    }

    /**
     * @throws Exception
     */
    public function testSearchByFaceId(): void
    {
        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $faceSetName = $this->randomFaceSetName();

        $this->createV1FaceSet($frsClient,$faceSetName);

        $faceId = ($this->addTestFaceByBase64V1($frsClient,$faceSetName)
                       ->getResult()
                       ->getFaces()[0]
        )->getFaceId();

        $response = $frsClient
            ->getSearchService()
            ->searchFaceByFaceId($faceSetName,$faceId,1000,0.99);

        // {
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
        //            "similarity": 1
        //        }
        //    ]
        //}

        $this->assertEquals(200,$response->getStatusCode());
        $this->assertGreaterThanOrEqual(0,count($response->getResult()->getComplexFaces()));

        $this->deleteV1FaceSet($frsClient,$faceSetName);
    }
}