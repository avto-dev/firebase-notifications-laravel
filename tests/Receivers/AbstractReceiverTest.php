<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel\Tests\Receivers;

use AvtoDev\FirebaseNotificationsChannel\Tests\AbstractTestCase;
use AvtoDev\FirebaseNotificationsChannel\Receivers\FcmNotificationReceiverInterface;

abstract class AbstractReceiverTest extends AbstractTestCase
{
    /**
     * @var string
     */
    protected $target_name;

    /**
     * @var string
     */
    protected $target_value;

    /**
     * @return void
     */
    public function testGetTargetArray(): void
    {
        $this->assertEquals([$this->target_name => $this->target_value], $this->getReceiver()->getTarget());
    }

    /**
     * @return FcmNotificationReceiverInterface
     */
    abstract protected function getReceiver();
}
