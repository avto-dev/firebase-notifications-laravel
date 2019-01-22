<?php

namespace AvtoDev\FirebaseCloudMessaging\Test\Receivers;

use AvtoDev\FirebaseCloudMessaging\Receivers\FcmDeviceReceiver;
use AvtoDev\FirebaseCloudMessaging\Receivers\FcmNotificationReceiverInterface;

/**
 * @coversDefaultClass \AvtoDev\FirebaseCloudMessaging\Receivers\FcmDeviceReceiver
 */
class FcmDeviceReceiverTest extends AbstractReceiverTest
{
    protected $target_name = 'token';

    protected $target_value = 'test_token';

    /**
     * @covers ::getToken()
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testGetTarget()
    {
        static::assertEquals($this->target_value, $this->getReceiver()->getToken());
    }

    /**
     * {@inheritdoc}
     * @return FcmNotificationReceiverInterface|FcmDeviceReceiver
     */
    protected function getReceiver()
    {
        return new FcmDeviceReceiver($this->target_value);
    }
}
