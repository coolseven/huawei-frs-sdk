<?php


namespace HuaweiFrsSdk\Access\HttpResponse\FaceSet;


use HuaweiFrsSdk\Access\HttpResponse\AbstractResponse;
use HuaweiFrsSdk\Client\Param\ExternalFieldDefinition;
use HuaweiFrsSdk\Client\Param\ExternalFieldDefinitions;
use HuaweiFrsSdk\Client\Result\Common\FaceSetInfo;
use HuaweiFrsSdk\Client\Result\FaceSet\GetFaceSetResult;
use HuaweiFrsSdk\Exceptions\ResponseValidationException;

class GetFaceSetResponse extends AbstractResponse
{
    /**
     * @throws ResponseValidationException
     */
    public function validate() : void
    {
        $body = $this->body;

        if (!isset($body['face_set_info'])) {
            throw new ResponseValidationException(
                $this->response,
                'missing face_set_info in response body'
            );
        }

        foreach (['face_number', 'face_set_id', 'face_set_name', 'create_date', 'face_set_capacity'] as $field) {
            if (!isset($body['face_set_info'][$field])) {
                throw new ResponseValidationException(
                    $this->response,
                    "missing {$field} in response body.face_set_info"
                );
            }
        }
    }

    /**
     * @return GetFaceSetResult
     */
    public function getResult() : GetFaceSetResult
    {
        $faceSetInfo = $this->body['face_set_info'];

        $externalFieldDefinitions = new ExternalFieldDefinitions();
        if (isset($faceSetInfo['external_fields'])) {
            foreach ($faceSetInfo['external_fields'] as $key => $info) {
                $externalFieldDefinitions->addExternalField(
                    new ExternalFieldDefinition($key, $info['type'])
                );
            }
        }

        return new GetFaceSetResult(
            new FaceSetInfo(
                $faceSetInfo['face_set_id'],
                $faceSetInfo['face_set_name'],
                $faceSetInfo['face_number'],
                $faceSetInfo['create_date'],
                $faceSetInfo['face_set_capacity'],
                $externalFieldDefinitions
            )
        );
    }
}