<?php

namespace HuaweiFrsSdk\Common;


class FrsPaths
{
    /**
     * GET '/v1/{project_id}/face-sets/{face_set_name}/search'
     */
    public const FACE_SEARCH = '/v1/%s/face-sets/%s/search';

    /**
     * POST '/v1/{project_id}/face-sets'
     */
    public const FACE_SET_CREATE = '/v1/%s/face-sets';

    /**
     * GET '/v1/{project_id}/face-sets'
     */
    public const FACE_SET_GET_ALL = '/v1/%s/face-sets';

    /**
     * GET '/v1/{project_id}/face-sets/{face_set_name}'
     */
    public const FACE_SET_GET_ONE = '/v1/%s/face-sets/%s';

    /**
     * DELETE '/v1/{project_id}/face-sets/{face_set_name}'
     */
    public const FACE_SET_DELETE = '/v1/%s/face-sets/%s';

    /**
     * GET '/v1/{project_id}/face-sets/{face_set_name}?offset={offset}&limit={limit}'
     */
    public const FACE_GET_RANGE = '/v1/%s/face-sets/%s/faces?offset=%d&limit=%d';

    /**
     * GET '/v1/{project_id}/face-sets/{face_set_name}/faces?face_id={face_id}'
     */
    public const FACE_GET_ONE = '/v1/%s/face-sets/%s/faces?face_id=%s';

    /**
     * POST '/v1/{project_id}/face-sets/{face_set_name}/faces'
     */
    public const FACE_ADD    = '/v1/%s/face-sets/%s/faces';

    /**
     * PUT '/v1/{project_id}/face-sets/{face_set_name}/faces'
     */
    public const FACE_UPDATE            = '/v1/%s/face-sets/%s/faces';

    /**
     * DELETE '/v1/{project_id}/face-sets/{face_set_name}/faces?face_id={face_id}'
     */
    public const FACE_DELETE_BY_FACE_ID = '/v1/%s/face-sets/%s/faces?face_id=%s';

    /**
     * DELETE '/v1/{project_id}/face-sets/{face_set_name}/faces?external_image_id={external_image_id}'
     */
    public const FACE_DELETE_BY_EXTERNAL_IMAGE_ID = '/v1/%s/face-sets/%s/faces?external_image_id=%s';

    /**
     * DELETE '/v1/{project_id}/face-sets/{face_set_name}/faces?{external_field_key}={external_filed_value}'
     */
    public const FACE_DELETE_BY_EXTERNAL_FIELD = '/v1/%s/face-sets/%s/faces?%s=%s';

    /**
     * DELETE '/v1/{project_id}/face-sets/{face_set_name}/faces/batch'
     */
    public const FACE_BATCH_DELETE_BY_FILTER = '/v1/%s/face-sets/%s/faces/batch';

    /**
     * POST '/v1/{project_id}/face-detect'
     */
    public const FACE_DETECT = '/v1/%s/face-detect';

    /**
     * POST '/v1/{project_id}/face-compare'
     */
    public const FACE_COMPARE = '/v1/%s/face-compare';

    /**
     * POST '/v1/{project_id}/live-detect'
     */
    public const LIVE_DETECT = '/v1/%s/live-detect';
}