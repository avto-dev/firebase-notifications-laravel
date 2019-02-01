<?php

namespace AvtoDev\FirebaseNotificationsChannel\Tests\Exceptions;

use AvtoDev\FirebaseNotificationsChannel\Tests\AbstractTestCase;
use AvtoDev\FirebaseNotificationsChannel\Exceptions\CouldNotSendNotification;

/**
 * Class CouldNotSendNotificationTest.
 *
 * @coversDefaultClass \AvtoDev\FirebaseNotificationsChannel\Exceptions\CouldNotSendNotification
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
