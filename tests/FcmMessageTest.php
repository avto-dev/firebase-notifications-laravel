<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel\Tests;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\Arrayable;
use AvtoDev\FirebaseNotificationsChannel\FcmMessage;
use AvtoDev\FirebaseNotificationsChannel\PlatformSettings\AppleFcmPlatformSettings;
use AvtoDev\FirebaseNotificationsChannel\PlatformSettings\AndroidFcmPlatformSettings;
use AvtoDev\FirebaseNotificationsChannel\PlatformSettings\WebpushFcmPlatformSettings;

/**
 * Class FcmMessageTest.
 *
 * @covers \AvtoDev\FirebaseNotificationsChannel\FcmMessage
 */
class FcmMessageTest extends AbstractTestCase
{
    /**
     * @var FcmMessage
     */
    protected $fcm_message;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->fcm_message = new FcmMessage;
    }

    public function dataProvider()
    {
        return [
            ['data', ['key' => 'value']],
            ['title', 'title text', 'notification.title'],
            ['body', 'body text', 'notification.body'],
            ['android', new AndroidFcmPlatformSettings],
            ['webpush', new WebpushFcmPlatformSettings],
            ['apns', new AppleFcmPlatformSettings],
        ];
    }

    /**
     * @param $property
     * @param $value
     * @param $path
     *
     * @throws \ReflectionException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     *
     * @dataProvider dataProvider
     */
    public function testSetters($property, $value, $path = null)
    {
        $this->fcm_message->{'set' . Str::title($property)}($value);

        $this->assertEquals($value, $this->getObjectAttribute($this->fcm_message, $property));

        if ($path === null) {
            $path = $property;
        }

        if ($value instanceof Arrayable) {
            $this->assertEquals($value, $this->fcm_message->{'get' . Str::title($property)}());
            $value = $value->toArray();
        }

        $this->assertEquals($value, Arr::get($this->fcm_message->toArray(), $path));
    }
}
