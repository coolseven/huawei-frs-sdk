<?php

namespace HuaweiFrsSdk\Tests\V2;


use HuaweiFrsSdk\Client\Param\AuthInfo;
use HuaweiFrsSdk\Client\FrsClient;
use HuaweiFrsSdk\Tests\BaseTestCase;

class CompareServiceTest extends BaseTestCase
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
        $this->ak = getenv('V2_HUAWEI_FRS_AK') ;
        $this->sk = getenv('V2_HUAWEI_FRS_SK') ;
        $this->endpoint = getenv('V2_HUAWEI_FRS_ENDPOINT') ;

        $this->authInfo = new AuthInfo($this->endpoint,$this->ak,$this->sk);

        $this->projectId = getenv('V2_HUAWEI_FRS_PROJECT_ID');
    }

    public function testCompareFaceByBase64(): void
    {
        $imageABase64 = base64_encode(
            file_get_contents(__DIR__.'/../images/donald_trump.jpeg')
        );
        $imageBBase64 = base64_encode(
            file_get_contents(__DIR__.'/../images/donald_trump.jpeg')
        );

        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $response = $frsClient
            ->getApiCollectionV2()
            ->getCompareService()
            ->compareFaceByBase64($imageABase64, $imageBBase64);

        // {
        //    "similarity": 1,
        //    "image1_face": {
        //        "bounding_box": {
        //            "width": 225,
        //            "top_left_x": 153,
        //            "top_left_y": 163,
        //            "height": 225
        //        }
        //    },
        //    "image2_face": {
        //        "bounding_box": {
        //            "width": 225,
        //            "top_left_x": 153,
        //            "top_left_y": 163,
        //            "height": 225
        //        }
        //    }
        //}

        $this->assertEquals(200,$response->getStatusCode());
    }

    public function testCompareFaceByLocalFile(): void
    {
        $imageAFilePath = __DIR__.'/../images/donald_trump.jpeg';
        $imageBFilePath = __DIR__.'/../images/donald_trump.jpeg';

        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $response = $frsClient
            ->getApiCollectionV2()
            ->getCompareService()
            ->compareFaceByLocalFile($imageAFilePath,$imageBFilePath);

        // {
        //    "similarity": 1,
        //    "image1_face": {
        //        "bounding_box": {
        //            "width": 225,
        //            "top_left_x": 153,
        //            "top_left_y": 163,
        //            "height": 225
        //        }
        //    },
        //    "image2_face": {
        //        "bounding_box": {
        //            "width": 225,
        //            "top_left_x": 153,
        //            "top_left_y": 163,
        //            "height": 225
        //        }
        //    }
        //}

        $this->assertEquals(200,$response->getStatusCode());
    }
}