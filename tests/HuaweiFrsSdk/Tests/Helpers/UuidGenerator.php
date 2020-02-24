<?php


namespace HuaweiFrsSdk\Tests\Helpers;


use Ramsey\Uuid\Codec\TimestampFirstCombCodec;
use Ramsey\Uuid\Generator\CombGenerator;
use Ramsey\Uuid\UuidFactory;

class UuidGenerator
{
    private static $uuidFactory;

    /**
     * Generate a time-ordered UUID (version 4).
     *
     * @return \Ramsey\Uuid\UuidInterface
     * @throws \Exception
     */
    public static function orderedUuid()
    {
        if (static::$uuidFactory) {
            return call_user_func(static::$uuidFactory);
        }

        $factory = new UuidFactory();

        $factory->setRandomGenerator(new CombGenerator(
            $factory->getRandomGenerator(),
            $factory->getNumberConverter()
        ));

        $factory->setCodec(new TimestampFirstCombCodec(
            $factory->getUuidBuilder()
        ));

        return $factory->uuid4();
    }
}