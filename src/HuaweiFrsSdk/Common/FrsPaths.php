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
}