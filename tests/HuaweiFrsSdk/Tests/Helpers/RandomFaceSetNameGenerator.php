<?php


namespace HuaweiFrsSdk\Tests\Helpers;


trait RandomFaceSetNameGenerator
{
    /**
     * @param string $prefix
     *
     * @return string
     * @throws \Exception
     */
    public function randomFaceSetName(string $prefix='phpunit_'): string
    {
        return $prefix. UuidGenerator::orderedUuid()->toString();
    }
}