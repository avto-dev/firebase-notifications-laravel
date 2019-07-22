<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel\Tests\PlatformSettings;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\Arrayable;
use AvtoDev\FirebaseNotificationsChannel\Tests\AbstractTestCase;

abstract class AbstractPlatformSettingsTest extends AbstractTestCase
{
    /**
     * @return array
     */
    abstract public function dataProvider(): array;

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
    public function testSetters($property, $array_path, $value): void
    {
        $platform_settings = $this->getPlatformSetting();

        $platform_settings->{'set' . Str::camel($property)}($value);

        $this->assertEquals($value, $this->getObjectAttribute($platform_settings, $property));
        $this->assertEquals($value, Arr::get($platform_settings->toArray(), $array_path));
    }

    /**
     * @return Arrayable
     */
    abstract protected function getPlatformSetting();
}
