<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel\Tests\Exceptions;

use AvtoDev\FirebaseNotificationsChannel\Tests\AbstractTestCase;
use AvtoDev\FirebaseNotificationsChannel\Exceptions\CouldNotSendNotification;

/**
 * @covers \AvtoDev\FirebaseNotificationsChannel\Exceptions\CouldNotSendNotification
 */
class CouldNotSendNotificationTest extends AbstractTestCase
{
    /**
     * Check exception message.
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testInvalidNotification(): void
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
