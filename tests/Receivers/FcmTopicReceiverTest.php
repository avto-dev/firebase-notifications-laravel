<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel\Tests\Receivers;

use AvtoDev\FirebaseNotificationsChannel\Receivers\FcmTopicReceiver;
use AvtoDev\FirebaseNotificationsChannel\Receivers\FcmNotificationReceiverInterface;

/**
 * @coversDefaultClass \AvtoDev\FirebaseNotificationsChannel\Receivers\FcmTopicReceiver
 */
class FcmTopicReceiverTest extends AbstractReceiverTest
{
    /**
     * @var string
     */
    protected $target_name = 'topic';

    /**
     * @var string
     */
    protected $target_value = 'test_topic';

    /**
     * @covers ::getTopic()
     */
    public function testGetTarget(): void
    {
        $this->assertEquals($this->target_value, $this->getReceiver()->getTopic());
    }

    /**
     * @return FcmNotificationReceiverInterface|FcmTopicReceiver
     */
    protected function getReceiver()
    {
        return new FcmTopicReceiver($this->target_value);
    }
}
