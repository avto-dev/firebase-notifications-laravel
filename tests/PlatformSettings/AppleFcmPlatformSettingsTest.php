<?php

namespace AvtoDev\FirebaseCloudMessaging\Test\PlatformSettings;

use AvtoDev\FirebaseCloudMessaging\PlatformSettings\AppleFcmPlatformSettings;

/**
 * @coversDefaultClass \AvtoDev\FirebaseCloudMessaging\PlatformSettings\AppleFcmPlatformSettingsTest
 */
class AppleFcmPlatformSettingsTest extends AbstractPlatformSettingsTest
{
    /**
     * @return array
     */
    public function dataProvider()
    {
        return [
            ['headers', 'headers', ['test_header', 'test_header2']],
            ['title', 'payload.alert.title', 'title_test'],
            ['body', 'payload.alert.body', 'body_test'],
            ['title_loc_key', 'payload.alert.title-loc-key', 'title_loc_key_test'],
            ['title_loc_args', 'payload.alert.title-loc-args', ['title_loc_args_1', 'title_loc_args_2']],
            ['action_loc_key', 'payload.alert.action-loc-key', 'action_loc_key_test'],
            ['loc_key', 'payload.alert.loc-key', 'loc_key_test'],
            ['loc_args', 'payload.alert.loc-args', ['loc_args_1', 'loc_args_2']],
            ['launch_image', 'payload.alert.launch-image', 'launch_image_test'],
            ['badge', 'payload.badge', 123],
            ['sound', 'payload.sound', 'sound_test'],
            ['content_available', 'payload.content-available', 234],
            ['category', 'payload.category', 'category_test'],
            ['thread_id', 'payload.thread-id', 'thread_id_test'],
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
