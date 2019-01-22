<?php

namespace AvtoDev\FirebaseCloudMessaging\Test\Exceptions;

use AvtoDev\FirebaseCloudMessaging\Test\AbstractTestCase;
use AvtoDev\FirebaseCloudMessaging\Exceptions\CouldNotSendNotification;

/**
 * Class CouldNotSendNotificationTest.
 *
 * @coversDefaultClass \AvtoDev\FirebaseCloudMessaging\Exceptions\CouldNotSendNotification
 */
class CouldNotSendNotificationTest extends AbstractTestCase
{
    /**
     * Check exception message.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testInvalidNotification()
    {
        $this->assertInstanceOf(
            CouldNotSendNotification::class,
            CouldNotSendNotification::invalidNotification()
        );

        $this->assertEquals(
            'Can\'t convert notification to FCM message',
            CouldNotSendNotification::invalidNotification()->getMessage()
        );
    }
}
