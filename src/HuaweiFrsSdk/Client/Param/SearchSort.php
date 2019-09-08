<?php
/**
 * PROJECT: huawei-frs-sdk
 * FILENAME: SearchSort.php
 * HOMEPAGE: https://github.com/coolseven/huaweicloud-sdk-php-frs
 */

namespace HuaweiFrsSdk\Client\Param;


class SearchSort
{
    /**
     * @var array
     */
    private $searchSort = [];

    public function addSortField( string $key, string $sortType = SortType::DESC ) : void
    {
        $this->searchSort[$key] = $sortType;
    }


    /**
     * @return array
     */
    public function getSearchSort() : array
    {
        return $this->searchSort;
    }


}