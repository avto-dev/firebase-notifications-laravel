<?php

namespace AvtoDev\FirebaseCloudMessaging\Test\Receivers;

use AvtoDev\FirebaseCloudMessaging\Receivers\FcmTopicReceiver;
use AvtoDev\FirebaseCloudMessaging\Receivers\FcmNotificationReceiverInterface;

/**
 * @coversDefaultClass \AvtoDev\FirebaseCloudMessaging\Receivers\FcmTopicReceiver
 */
class FcmTopicReceiverTest extends AbstractReceiverTest
{
    protected $target_name = 'topic';

    protected $target_value = 'test_topic';

    /**
     * @covers ::getTopic()
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testGetTarget()
    {
        static::assertEquals($this->target_value, $this->getReceiver()->getTopic());
    }

    /**
     * @return FcmNotificationReceiverInterface|FcmTopicReceiver
     */
    protected function getReceiver()
    {
        return new FcmTopicReceiver($this->target_value);
    }
}
