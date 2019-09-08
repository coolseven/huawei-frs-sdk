<?php
/**
 * PROJECT: huawei-frs-sdk
 * FILENAME: SearchReturnFields.php
 * HOMEPAGE: https://github.com/coolseven/huaweicloud-sdk-php-frs
 */

namespace HuaweiFrsSdk\Client\Param;



class SearchReturnFields
{
    private $returnFields = [];

    public function addReturnField( string $key ) : void
    {
        $this->returnFields[] = $key;

        $this->returnFields = array_unique($this->returnFields);
    }

    /**
     * @return array
     */
    public function getReturnFields() : array
    {
        return $this->returnFields;
    }
}