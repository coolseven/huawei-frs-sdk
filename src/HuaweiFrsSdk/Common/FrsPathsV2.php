<?php

namespace HuaweiFrsSdk\Common;


class FrsPathsV2
{
    /**
     * GET '/v2/{project_id}/face-sets/{face_set_name}/search'
     */
    public const FACE_SEARCH = '/v2/%s/face-sets/%s/search';

    /**
     * POST '/v2/{project_id}/face-sets'
     */
    public const FACE_SET_CREATE = '/v2/%s/face-sets';

    /**
     * GET '/v2/{project_id}/face-sets'
     */
    public const FACE_SET_GET_ALL = '/v2/%s/face-sets';

    /**
     * GET '/v2/{project_id}/face-sets/{face_set_name}'
     */
    public const FACE_SET_GET_ONE = '/v2/%s/face-sets/%s';

    /**
     * DELETE '/v2/{project_id}/face-sets/{face_set_name}'
     */
    public const FACE_SET_DELETE = '/v2/%s/face-sets/%s';

    /**
     * GET '/v2/{project_id}/face-sets/{face_set_name}?offset={offset}&limit={limit}'
     */
    public const FACE_GET_RANGE = '/v2/%s/face-sets/%s/faces?offset=%d&limit=%d';

    /**
     * GET '/v2/{project_id}/face-sets/{face_set_name}/faces?face_id={face_id}'
     */
    public const FACE_GET_ONE = '/v2/%s/face-sets/%s/faces?face_id=%s';

    /**
     * POST '/v2/{project_id}/face-sets/{face_set_name}/faces'
     */
    public const FACE_ADD    = '/v2/%s/face-sets/%s/faces';

    /**
     * PUT '/v2/{project_id}/face-sets/{face_set_name}/faces'
     */
    public const FACE_UPDATE            = '/v2/%s/face-sets/%s/faces';

    /**
     * DELETE '/v2/{project_id}/face-sets/{face_set_name}/faces?face_id={face_id}'
     */
    public const FACE_DELETE_BY_FACE_ID = '/v2/%s/face-sets/%s/faces?face_id=%s';

    /**
     * DELETE '/v2/{project_id}/face-sets/{face_set_name}/faces?external_image_id={external_image_id}'
     */
    public const FACE_DELETE_BY_EXTERNAL_IMAGE_ID = '/v2/%s/face-sets/%s/faces?external_image_id=%s';

    /**
     * DELETE '/v2/{project_id}/face-sets/{face_set_name}/faces?{external_field_key}={external_filed_value}'
     */
    public const FACE_DELETE_BY_EXTERNAL_FIELD = '/v2/%s/face-sets/%s/faces?%s=%s';

    /**
     * DELETE '/v2/{project_id}/face-sets/{face_set_name}/faces/batch'
     */
    public const FACE_BATCH_DELETE_BY_FILTER = '/v2/%s/face-sets/%s/faces/batch';

    /**
     * POST '/v2/{project_id}/face-detect'
     */
    public const FACE_DETECT = '/v2/%s/face-detect';

    /**
     * POST '/v2/{project_id}/face-compare'
     */
    public const FACE_COMPARE = '/v2/%s/face-compare';
}