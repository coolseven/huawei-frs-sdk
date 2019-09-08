<?php
/**
 * PROJECT: huawei-frs-sdk
 * FILENAME: SearchFaceResult.php
 * HOMEPAGE: https://github.com/coolseven/huaweicloud-sdk-php-frs
 */

namespace HuaweiFrsSdk\Client\Result;


use HuaweiFrsSdk\Client\Result\Common\ComplexFace;

class SearchFaceResult
{
    /**
     * @var $complexFaces ComplexFace[]
     */
    private $complexFaces;

    public function __construct(array $complexFaces = [] )
    {
        $this->complexFaces = $complexFaces;
    }
}