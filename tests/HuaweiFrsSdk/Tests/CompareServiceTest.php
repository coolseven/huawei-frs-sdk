<?php

namespace HuaweiFrsSdk\Tests;


use HuaweiFrsSdk\Client\Param\AuthInfo;
use HuaweiFrsSdk\Client\FrsClient;
use PHPUnit_Framework_TestCase;

class CompareServiceTest extends PHPUnit_Framework_TestCase
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
        $this->ak = getenv('HUAWEI_FRS_AK') ;
        $this->sk = getenv('HUAWEI_FRS_SK') ;
        $this->endpoint = getenv('HUAWEI_FRS_ENDPOINT') ;

        $this->authInfo = new AuthInfo($this->endpoint,$this->ak,$this->sk);

        $this->projectId = getenv('HUAWEI_FRS_PROJECT_ID');
        $this->faceSetName = getenv('HUAWEI_FRS_FACE_SET_NAME');
        $this->faceId = getenv('HUAWEI_FRS_SEARCH_FACE_ID');
    }

    public function testCompareFaceByBase64(): void
    {
        $imageABase64 = base64_encode(file_get_contents(__DIR__.'/images/donald_trump.jpeg'));
        $imageBBase64 = base64_encode(file_get_contents(__DIR__.'/images/donald_trump.jpeg'));

        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $response = $frsClient->getCompareService()->compareFaceByBase64($imageABase64, $imageBBase64);

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
        echo '>>>>>>>>>>>>' .PHP_EOL.var_export($response->getBody()->getContents(),true).PHP_EOL.'<<<<<<<<<<<<'.PHP_EOL;

        $this->assertEquals(200,$response->getStatusCode());
    }

    public function testCompareFaceByLocalFile(): void
    {
        $imageAFilePath = __DIR__.'/images/donald_trump.jpeg';
        $imageBFilePath = __DIR__.'/images/donald_trump.jpeg';

        $frsClient = new FrsClient($this->authInfo,$this->projectId);

        $response = $frsClient->getCompareService()->compareFaceByLocalFile($imageAFilePath,$imageBFilePath);

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
        echo '>>>>>>>>>>>>' .PHP_EOL.var_export($response->getBody()->getContents(),true).PHP_EOL.'<<<<<<<<<<<<'.PHP_EOL;

        $this->assertEquals(200,$response->getStatusCode());
    }
}