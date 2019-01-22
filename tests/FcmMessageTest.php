<?php

namespace AvtoDev\FirebaseCloudMessaging\Test;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Contracts\Support\Arrayable;
use AvtoDev\FirebaseCloudMessaging\FcmMessage;
use AvtoDev\FirebaseCloudMessaging\PlatformSettings\AppleFcmPlatformSettings;
use AvtoDev\FirebaseCloudMessaging\PlatformSettings\AndroidFcmPlatformSettings;
use AvtoDev\FirebaseCloudMessaging\PlatformSettings\WebpushFcmPlatformSettings;

/**
 * Class FcmMessageTest.
 *
 * @covers \AvtoDev\FirebaseCloudMessaging\FcmMessage
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
    public function setUp()
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
        $this->fcm_message->{'set'.Str::title($property)}($value);

        static::assertEquals($value, static::getProperty($this->fcm_message, $property));

        if ($path === null) {
            $path = $property;
        }

        if ($value instanceof Arrayable) {
            static::assertEquals($value, $this->fcm_message->{'get'.Str::title($property)}());
            $value = $value->toArray();
        }

        static::assertEquals($value, Arr::get($this->fcm_message->toArray(), $path));
    }
}
