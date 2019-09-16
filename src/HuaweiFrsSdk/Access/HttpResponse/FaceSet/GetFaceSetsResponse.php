<?php


namespace HuaweiFrsSdk\Access\HttpResponse\FaceSet;


use HuaweiFrsSdk\Access\HttpResponse\AbstractResponse;
use HuaweiFrsSdk\Client\Param\ExternalFieldDefinition;
use HuaweiFrsSdk\Client\Param\ExternalFieldDefinitions;
use HuaweiFrsSdk\Client\Result\Common\FaceSetInfo;
use HuaweiFrsSdk\Client\Result\FaceSet\GetFaceSetsResult;
use HuaweiFrsSdk\Exceptions\ResponseValidationException;

class GetFaceSetsResponse extends AbstractResponse
{

    /**
     * @throws ResponseValidationException
     */
    public function validate() : void 
    {
        $body = $this->body;

        if (!isset($body['face_sets_info'])) {
            throw new ResponseValidationException(
                $this->response,
                'missing face_sets_info in response body'
            );
        }

        $requiredFields = [
            'face_set_info' => [
                'face_number',
                'face_set_id',
                'face_set_name',
                'create_date',
                'face_set_capacity',
                'external_fields',
            ],
        ];

        foreach ($body['face_sets_info'] as $index => $faceSetInfo) {
            foreach ($requiredFields['face_set_info'] as $field) {
                if (!isset($faceSetInfo[$field])) {
                    throw new ResponseValidationException(
                        $this->response,
                        "missing {$field} in response body.face_sets_info.[{$index}]"
                    );
                }
            }
        }
    }

    public function getResult() : GetFaceSetsResult
    {
        $faceSetInfoArray = [];

        foreach ($this->body['face_sets_info'] as $faceSetInfo) {

            $externalFieldDefinitions = new ExternalFieldDefinitions();

            foreach ($faceSetInfo['external_fields'] as $key => $info) {
                $externalFieldDefinitions->addExternalField(
                    new ExternalFieldDefinition($key, $info['type'])
                );
            }

            $faceSetInfoArray[] = new FaceSetInfo(
                $faceSetInfo['face_set_id'],
                $faceSetInfo['face_set_name'],
                $faceSetInfo['face_number'],
                $faceSetInfo['create_date'],
                $faceSetInfo['face_set_capacity'],
                $externalFieldDefinitions
            );
        }

        return new GetFaceSetsResult($faceSetInfoArray);
    }
}