<?php
/**
 * PROJECT: huawei-frs-sdk
 * FILENAME: SearchService.php
 * HOMEPAGE: https://github.com/coolseven/huaweicloud-sdk-php-frs
 */

namespace HuaweiFrsSdk\Client\Service;


use HuaweiFrsSdk\Access\FrsAccess;
use HuaweiFrsSdk\Access\HttpResponse;
use HuaweiFrsSdk\Client\Param\SearchReturnFields;
use HuaweiFrsSdk\Client\Param\SearchSort;
use HuaweiFrsSdk\Common\FrsUris;
use HuaweiFrsSdk\Common\ImageTypes;
use InvalidArgumentException;

class SearchService
{
    /**
     * @var FrsAccess
     */
    private $accessService;
    /**
     * @var string
     */
    private $projectId;

    /**
     * SearchService constructor.
     *
     * @param FrsAccess $accessService
     * @param string    $projectId
     */
    public function __construct( FrsAccess $accessService, string $projectId)
    {
        $this->accessService = $accessService;
        $this->projectId = $projectId;
    }

    /**
     * @param string                  $faceSetName
     * @param string                  $imageBase64
     * @param int                     $topN
     * @param float                   $threshold
     * @param SearchSort|null         $searchSort
     * @param SearchReturnFields|null $searchReturnFields
     * @param string|null             $filter
     *
     * @return HttpResponse
     * @throws \HuaweiFrsSdk\Common\FrsClientException
     * @throws \HuaweiFrsSdk\Common\FrsServerException
     */
    public function searchFaceByBase64(
        string $faceSetName,
        string $imageBase64,
        int $topN = 5,
        float $threshold = 0.93,
        SearchSort $searchSort = null,
        SearchReturnFields $searchReturnFields = null,
        string $filter = null
    ) : HttpResponse
    {
        return $this->searchFace($faceSetName,ImageTypes::BASE64,$imageBase64,$topN,$threshold,$searchSort,$searchReturnFields,$filter);
    }

    /**
     * @param string                  $faceSetName
     * @param string                  $faceId
     * @param int                     $topN
     * @param float                   $threshold
     * @param SearchSort|null         $searchSort
     * @param SearchReturnFields|null $searchReturnFields
     * @param string|null             $filter
     *
     * @return HttpResponse
     * @throws \HuaweiFrsSdk\Common\FrsClientException
     * @throws \HuaweiFrsSdk\Common\FrsServerException
     */
    public function searchFaceByFaceId(
        string $faceSetName,
        string $faceId,
        int $topN = 5,
        float $threshold = 0.93,
        SearchSort $searchSort = null,
        SearchReturnFields $searchReturnFields = null,
        string $filter = null
    ) : HttpResponse
    {
        return $this->searchFace($faceSetName,ImageTypes::FACE_ID,$faceId,$topN,$threshold,$searchSort,$searchReturnFields,$filter);
    }

    /**
     * @param string                  $faceSetName
     * @param string                  $obsUrl
     * @param int                     $topN
     * @param float                   $threshold
     * @param SearchSort|null         $searchSort
     * @param SearchReturnFields|null $searchReturnFields
     * @param string|null             $filter
     *
     * @return HttpResponse
     * @throws \HuaweiFrsSdk\Common\FrsClientException
     * @throws \HuaweiFrsSdk\Common\FrsServerException
     */
    public function searchFaceByObsUrl(
        string $faceSetName,
        string $obsUrl,
        int $topN = 5,
        float $threshold = 0.93,
        SearchSort $searchSort = null,
        SearchReturnFields $searchReturnFields = null,
        string $filter = null
    ) : HttpResponse
    {
        return $this->searchFace($faceSetName,ImageTypes::OBS_URL,$obsUrl,$topN,$threshold,$searchSort,$searchReturnFields,$filter);
    }

    /**
     * @param string                  $faceSetName
     * @param string                  $imageType
     * @param string                  $image
     * @param int                     $topN
     * @param float                   $threshold
     * @param SearchSort|null         $searchSort
     * @param SearchReturnFields|null $searchReturnFields
     * @param string|null             $filter
     *
     * @return HttpResponse
     * @throws \HuaweiFrsSdk\Common\FrsClientException
     * @throws \HuaweiFrsSdk\Common\FrsServerException
     */
    private function searchFace(
        string $faceSetName,
        string $imageType,
        string $image,
        int $topN,
        float $threshold,
        SearchSort $searchSort = null,
        SearchReturnFields $searchReturnFields = null,
        string $filter = null
    ) : HttpResponse
    {
        $uri = sprintf(FrsUris::FACE_SEARCH_URI, $this->projectId, $faceSetName);
        $body = [];

        switch ( $imageType ) {
            case ImageTypes::BASE64:
                $body['image_base64'] = $image;
                break;
            case ImageTypes::FACE_ID:
                $body['face_id'] = $image;
                break;
            case ImageTypes::OBS_URL:
                $body['image_url'] = $image;
                break;
            default:
                throw new InvalidArgumentException("imageType must be one of image_base64 / face_id / image_url ,but $imageType provided");
        }

        $body['top_n'] = $topN;
        $body['threshold'] = $threshold;

        if (!empty($searchSort)) {
            $body['sort'] = $searchSort->getSearchSort();
        }

        if (!empty($searchReturnFields)) {
            $body['return_fields'] = $searchReturnFields->getReturnFields();
        }

        if (!empty($filter)) {
            $body['filter'] = $filter;
        }

        return $this->accessService->post($uri,$body,'application/json');
    }
}