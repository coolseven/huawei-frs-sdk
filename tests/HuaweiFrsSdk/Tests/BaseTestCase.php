<?php


namespace HuaweiFrsSdk\Tests;


use HuaweiFrsSdk\Access\HttpResponse\Face\AddFaceResponse;
use HuaweiFrsSdk\Access\HttpResponse\FaceSet\CreateFaceSetResponse;
use HuaweiFrsSdk\Client\FrsClient;
use HuaweiFrsSdk\Client\Param\ExternalField;
use HuaweiFrsSdk\Client\Param\ExternalFieldDefinition;
use HuaweiFrsSdk\Client\Param\ExternalFieldDefinitions;
use HuaweiFrsSdk\Client\Param\ExternalFields;
use HuaweiFrsSdk\Client\Param\FieldTypes;
use HuaweiFrsSdk\Tests\Helpers\RandomExternalImageIdGenerator;
use HuaweiFrsSdk\Tests\Helpers\RandomFaceSetNameGenerator;
use PHPUnit\Framework\TestCase;

class BaseTestCase extends TestCase
{
    use RandomFaceSetNameGenerator;
    use RandomExternalImageIdGenerator;

    /**
     * @param FrsClient $frsClient
     * @param string    $faceSetName
     */
    public function deleteV2FaceSet(FrsClient $frsClient,string $faceSetName): void
    {
        $response = $frsClient
            ->getApiCollectionV2()
            ->getFaceSetService()
            ->deleteFaceSet($faceSetName);

        $this->assertEquals(200,$response->getStatusCode());
        $this->assertEquals($faceSetName,$response->getResult()->getFaceSetName());
    }

    /**
     * @param FrsClient $frsClient
     * @param string    $faceSetName
     */
    public function deleteV1FaceSet(FrsClient $frsClient,string $faceSetName): void
    {
        $response = $frsClient
            ->getFaceSetService()
            ->deleteFaceSet($faceSetName);

        $this->assertEquals(200,$response->getStatusCode());
        $this->assertEquals($faceSetName,$response->getResult()->getFaceSetName());
    }

    /**
     * @param FrsClient $frsClient
     * @param string    $faceSetName
     *
     * @return CreateFaceSetResponse
     */
    public function createV2FaceSet(FrsClient $frsClient,string $faceSetName): CreateFaceSetResponse
    {
        $externalFieldDefinitions = new ExternalFieldDefinitions([
            new ExternalFieldDefinition('id',FieldTypes::STRING),
            new ExternalFieldDefinition('number',FieldTypes::INTEGER),
            new ExternalFieldDefinition('timestamp',FieldTypes::LONG),
        ]);

        return $frsClient
            ->getApiCollectionV2()
            ->getFaceSetService()
            ->createFaceSet(
                $faceSetName,
                100000,
                $externalFieldDefinitions
            );
    }

    /**
     * @param FrsClient $frsClient
     * @param string    $faceSetName
     *
     * @return CreateFaceSetResponse
     */
    public function createV1FaceSet(FrsClient $frsClient,string $faceSetName): CreateFaceSetResponse
    {
        $externalFieldDefinitions = new ExternalFieldDefinitions([
            new ExternalFieldDefinition('id',FieldTypes::STRING),
            new ExternalFieldDefinition('number',FieldTypes::INTEGER),
            new ExternalFieldDefinition('timestamp',FieldTypes::LONG),
        ]);

        return $frsClient
            ->getFaceSetService()
            ->createFaceSet(
                $faceSetName,
                100000,
                $externalFieldDefinitions
            );
    }

    /**
     * @param FrsClient $frsClient
     * @param string    $faceSetName
     *
     * @return AddFaceResponse
     */
    public function addTestFaceByBase64V2(FrsClient $frsClient,string $faceSetName): AddFaceResponse
    {
        $imageFilePath = __DIR__.'/images/donald_trump.jpeg';

        $imageBase64 = base64_encode(file_get_contents($imageFilePath));

        $externalImageId = md5(file_get_contents($imageFilePath));

        return $frsClient
            ->getApiCollectionV2()
            ->getFaceService()
            ->addFaceByBase64($faceSetName,
                $imageBase64,
                $externalImageId,
                new ExternalFields([
                    new ExternalField('number', 90),
                    new ExternalField('id', 'id_01'),
                    new ExternalField('timestamp', 123456),
                ])
            );
    }

    /**
     * @param FrsClient $frsClient
     * @param string    $faceSetName
     *
     * @return AddFaceResponse
     */
    public function addTestFaceByBase64V1(FrsClient $frsClient,string $faceSetName): AddFaceResponse
    {
        $imageFilePath = __DIR__.'/images/donald_trump.jpeg';

        $imageBase64 = base64_encode(file_get_contents($imageFilePath));

        $externalImageId = md5(file_get_contents($imageFilePath));

        return $frsClient
            ->getFaceService()
            ->addFaceByBase64($faceSetName,
                $imageBase64,
                $externalImageId,
                new ExternalFields([
                    new ExternalField('number', 90),
                    new ExternalField('id', 'id_01'),
                    new ExternalField('timestamp', 123456),
                ])
            );
    }
}