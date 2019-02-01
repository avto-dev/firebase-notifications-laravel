<?php

namespace AvtoDev\FirebaseNotificationsChannel\Tests\Receivers;

use AvtoDev\FirebaseNotificationsChannel\Receivers\FcmTopicReceiver;
use AvtoDev\FirebaseNotificationsChannel\Receivers\FcmNotificationReceiverInterface;

/**
 * @coversDefaultClass \AvtoDev\FirebaseNotificationsChannel\Receivers\FcmTopicReceiver
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
