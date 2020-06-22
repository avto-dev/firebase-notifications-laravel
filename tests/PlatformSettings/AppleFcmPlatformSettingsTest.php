<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel\Tests\PlatformSettings;

use AvtoDev\FirebaseNotificationsChannel\PlatformSettings\AppleFcmPlatformSettings;

/**
 * @covers \AvtoDev\FirebaseNotificationsChannel\PlatformSettings\AppleFcmPlatformSettings
 */
class AppleFcmPlatformSettingsTest extends AbstractPlatformSettingsTest
{
    /**
     * @return array<array<string>>
     */
    public function dataProvider(): array
    {
        return [
            ['headers', 'headers', ['test_header', 'test_header2']],
            ['title', 'payload.aps.alert.title', 'title_test'],
            ['body', 'payload.aps.alert.body', 'body_test'],
            ['title_loc_key', 'payload.aps.alert.title-loc-key', 'title_loc_key_test'],
            ['title_loc_args', 'payload.aps.alert.title-loc-args', ['title_loc_args_1', 'title_loc_args_2']],
            ['action_loc_key', 'payload.aps.alert.action-loc-key', 'action_loc_key_test'],
            ['loc_key', 'payload.aps.alert.loc-key', 'loc_key_test'],
            ['loc_args', 'payload.aps.alert.loc-args', ['loc_args_1', 'loc_args_2']],
            ['launch_image', 'payload.aps.alert.launch-image', 'launch_image_test'],
            ['badge', 'payload.aps.badge', 123],
            ['sound', 'payload.aps.sound', 'sound_test'],
            ['content_available', 'payload.aps.content-available', 234],
            ['category', 'payload.aps.category', 'category_test'],
            ['thread_id', 'payload.aps.thread-id', 'thread_id_test'],
            ['mutable_content', 'payload.aps.mutable-content', true],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getPlatformSetting()
    {
        return new AppleFcmPlatformSettings;
    }
}
