<?php


namespace HuaweiFrsSdk\Access\HttpResponse\FaceSet;


use HuaweiFrsSdk\Access\HttpResponse\AbstractResponse;
use HuaweiFrsSdk\Client\Result\FaceSet\DeleteFaceSetResult;
use HuaweiFrsSdk\Exceptions\ResponseValidationException;

class DeleteFaceSetResponse extends AbstractResponse
{
    /**
     * @throws ResponseValidationException
     */
    public function validate() : void
    {
        $body = $this->body;

        if (!isset($body['face_set_name'])) {
            throw new ResponseValidationException(
                $this->response,
                'missing face_set_name in response body'
            );
        }
    }

    public function getResult() : DeleteFaceSetResult
    {
        return new DeleteFaceSetResult($this->body['face_set_name']);
    }
}