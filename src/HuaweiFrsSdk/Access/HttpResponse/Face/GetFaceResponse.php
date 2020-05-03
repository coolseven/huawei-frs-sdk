<?php


namespace HuaweiFrsSdk\Access\HttpResponse\Face;


use HuaweiFrsSdk\Access\HttpResponse\AbstractResponse;
use HuaweiFrsSdk\Client\Param\ExternalField;
use HuaweiFrsSdk\Client\Param\ExternalFields;
use HuaweiFrsSdk\Client\Result\Common\BoundingBox;
use HuaweiFrsSdk\Client\Result\Common\Face;
use HuaweiFrsSdk\Client\Result\Common\SimpleFace;
use HuaweiFrsSdk\Client\Result\Face\GetFaceResult;
use HuaweiFrsSdk\Exceptions\ResponseValidationException;

class GetFaceResponse extends AbstractResponse
{

    /**
     * @throws ResponseValidationException
     */
    public function validate() : void
    {

        foreach ( ['face_set_id','face_set_name','faces'] as $firstLevelField ) {
            if (!isset($this->body[$firstLevelField])) {
                throw new ResponseValidationException(
                    $this->response,
                    "missing {$firstLevelField} in response body"
                );
            }
        }

        $faces = $this->body['faces'];
        if (count($faces) > 1) {
            throw new ResponseValidationException(
                $this->response,
                "expects one face, but ".count($faces).' faces returned'
            );
        }

        $face = $faces[0];
        foreach ( ['face_id','external_image_id','bounding_box'] as $field ) {
            if (!isset($face[$field])) {
                throw new ResponseValidationException(
                    $this->response,
                    "missing {$field} in response.body.faces.[0]"
                );
            }
        }
    }

    /**
     * @return GetFaceResult
     */
    public function getResult() : GetFaceResult
    {
        $face = $this->body['faces'][0];

        $externalFields = new ExternalFields();
        if (isset($face['external_fields'])) {
            foreach ($face['external_fields'] as $key => $value) {
                $externalFields->addExternalField(
                    new ExternalField($key, $value)
                );
            }
        }


        return new GetFaceResult(
            $this->body['face_set_id'],
            $this->body['face_set_name'],
            new Face(
                new SimpleFace(
                    new BoundingBox(
                        intval($face['bounding_box']['top_left_x']),
                        intval($face['bounding_box']['top_left_y']),
                        intval($face['bounding_box']['width']),
                        intval($face['bounding_box']['height'])
                    )
                ),
                $face['external_image_id'],
                $face['face_id'],
                $externalFields
            )
        );
    }
}