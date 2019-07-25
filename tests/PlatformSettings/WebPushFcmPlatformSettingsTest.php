<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel\Tests\PlatformSettings;

use AvtoDev\FirebaseNotificationsChannel\PlatformSettings\WebpushFcmPlatformSettings;

/**
 * @covers \AvtoDev\FirebaseNotificationsChannel\PlatformSettings\WebpushFcmPlatformSettings
 */
class WebPushFcmPlatformSettingsTest extends AbstractPlatformSettingsTest
{
    /**
     * @return array[]
     */
    public function dataProvider(): array
    {
        return [
            ['headers', 'headers', ['test_header', 'test_header2']],
            ['data', 'data', ['data1', 1]],
            ['actions', 'notification.actions', ['test_action_1', 'test_action_2']],
            ['badge', 'notification.badge', 'test_badge'],
            ['body', 'notification.body', 'test_body'],
            ['data', 'notification.data', ['test_data']],
            ['dir', 'notification.dir', 'test_dir'],
            ['lang', 'notification.lang', 'test_lang'],
            ['tag', 'notification.tag', 'test_tag'],
            ['icon', 'notification.icon', 'test_icon'],
            ['image', 'notification.image', 'test_image'],
            ['renotify', 'notification.renotify', true],
            ['requireInteraction', 'notification.requireInteraction', true],
            ['silent', 'notification.silent', true],
            ['timestamp', 'notification.timestamp', 0],
            ['title', 'notification.title', 'test_title'],
            ['vibrate', 'notification.vibrate', true],
            ['link', 'fcm_options.link', 'link_test'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getPlatformSetting()
    {
        return new WebpushFcmPlatformSettings;
    }
}
