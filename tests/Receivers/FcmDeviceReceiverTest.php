<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel\Tests\Receivers;

use AvtoDev\FirebaseNotificationsChannel\Receivers\FcmDeviceReceiver;
use AvtoDev\FirebaseNotificationsChannel\Receivers\FcmNotificationReceiverInterface;

/**
 * @coversDefaultClass \AvtoDev\FirebaseNotificationsChannel\Receivers\FcmDeviceReceiver
 */
class FcmDeviceReceiverTest extends AbstractReceiverTest
{
    /**
     * @var string
     */
    protected $target_name = 'token';

    /**
     * @var string
     */
    protected $target_value = 'test_token';

    /**
     * @covers ::getToken()
     */
    public function testGetTarget(): void
    {
        $this->assertEquals($this->target_value, $this->getReceiver()->getToken());
    }

    /**
     * {@inheritdoc}
     *
     * @return FcmNotificationReceiverInterface|FcmDeviceReceiver
     */
    protected function getReceiver()
    {
        return new FcmDeviceReceiver($this->target_value);
    }
}
