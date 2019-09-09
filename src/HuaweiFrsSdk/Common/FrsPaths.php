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
    public const FACE_ADD     = '/v1/%s/face-sets/%s/faces';
}