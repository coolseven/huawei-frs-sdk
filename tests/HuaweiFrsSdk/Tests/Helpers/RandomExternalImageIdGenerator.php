<?php


namespace HuaweiFrsSdk\Tests\Helpers;


trait RandomExternalImageIdGenerator
{
    /**
     * @return string
     * @throws \Exception
     */
    public function randomExternalImageId(): string
    {
        return UuidGenerator::orderedUuid()->toString();
    }
}