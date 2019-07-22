<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel\Tests\Receivers;

use AvtoDev\FirebaseNotificationsChannel\Tests\AbstractTestCase;
use AvtoDev\FirebaseNotificationsChannel\Receivers\FcmNotificationReceiverInterface;

abstract class AbstractReceiverTest extends AbstractTestCase
{
    protected $target_name;

    protected $target_value;

    /**
     * @covers ::__construct
     *
     * @throws \ReflectionException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testGetConstruct(): void
    {
        $this->assertEquals($this->target_value, $this->getObjectAttribute($this->getReceiver(), $this->target_name));
    }

    /**
     * @covers ::getTarget()
     *
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
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
