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
     * Must contains array of array.
     *
     * [
     *   [$property, $array_path, $value]
     * ]
     *
     * @return array
     */
    abstract public function dataProvider(): array;

    /**
     * @return void
     */
    public function testSetters(): void
    {
        $platform_settings = $this->getPlatformSetting();

        foreach ($this->dataProvider() as [$property, $array_path, $value]) {
            $platform_settings->{'set' . Str::camel($property)}($value);

            $this->assertEquals($value, Arr::get($platform_settings->toArray(), $array_path));
        }
    }

    /**
     * @return Arrayable
     */
    abstract protected function getPlatformSetting();
}
