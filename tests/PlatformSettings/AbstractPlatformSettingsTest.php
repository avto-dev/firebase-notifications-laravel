<?php

namespace AvtoDev\FirebaseNotificationsChannel\Tests\PlatformSettings;

use Illuminate\Support\Str;
use Illuminate\Contracts\Support\Arrayable;
use AvtoDev\FirebaseNotificationsChannel\Tests\AbstractTestCase;

abstract class AbstractPlatformSettingsTest extends AbstractTestCase
{
    /**
     * @return array
     */
    abstract public function dataProvider();

    /**
     * @return Arrayable
     */
    abstract protected function getPlatformSetting();

    /**
     * @param $property
     * @param $array_path
     * @param $value
     *
     * @throws \ReflectionException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     *
     * @dataProvider dataProvider
     */
    public function testSetters($property, $array_path, $value)
    {
        $platform_settings = $this->getPlatformSetting();

        $platform_settings->{'set'.Str::camel($property)}($value);

        static::assertEquals($value, static::getProperty($platform_settings, $property));
        static::assertEquals($value, array_get($platform_settings->toArray(), $array_path));
    }
}
