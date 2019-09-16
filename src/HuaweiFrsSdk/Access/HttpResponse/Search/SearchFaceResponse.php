<?php


namespace HuaweiFrsSdk\Access\HttpResponse\Search;


use HuaweiFrsSdk\Access\HttpResponse\AbstractResponse;
use HuaweiFrsSdk\Client\Param\ExternalField;
use HuaweiFrsSdk\Client\Param\ExternalFields;
use HuaweiFrsSdk\Client\Result\Common\BoundingBox;
use HuaweiFrsSdk\Client\Result\Common\ComplexFace;
use HuaweiFrsSdk\Client\Result\Common\Face;
use HuaweiFrsSdk\Client\Result\Common\SimpleFace;
use HuaweiFrsSdk\Client\Result\Search\SearchFaceResult;
use HuaweiFrsSdk\Exceptions\ResponseValidationException;

class SearchFaceResponse extends AbstractResponse
{

    /**
     * @throws ResponseValidationException
     */
    public function validate() : void
    {
        $body = $this->body;

        if (!isset($body['faces'])) {
            throw new ResponseValidationException(
                $this->response,
                'missing faces in response body'
            );
        }

        foreach ( $body['faces'] as $index => $face ) {
            foreach ( ['face_id','external_image_id','similarity','bounding_box'] as $field ) {
                if (!isset($face[$field])) {
                    throw new ResponseValidationException(
                        $this->response,
                        "missing {$field} in response body.faces.[{$index}]"
                    );
                }
            }
        }

    }

    /**
     * @return SearchFaceResult
     */
    public function getResult() : SearchFaceResult
    {
        $complexFaces = [];

        foreach ( $this->body['faces'] as $face ) {

            $externalFields = new ExternalFields();
            if (isset($face['external_fields'])) {
                foreach ($face['external_fields'] as $key => $value) {
                    $externalFields->addExternalField(
                        new ExternalField($key, $value)
                    );
                }
            }

            $complexFaces[] = new ComplexFace(
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
                ),
                floatval($face['similarity'])
            );
        }

        return new SearchFaceResult($complexFaces);
    }
}