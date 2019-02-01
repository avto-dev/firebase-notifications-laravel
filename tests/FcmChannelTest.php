<?php

namespace AvtoDev\FirebaseNotificationsChannel\Tests;

use GuzzleHttp\Psr7\Response;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use AvtoDev\FirebaseNotificationsChannel\FcmChannel;
use AvtoDev\FirebaseNotificationsChannel\FcmMessage;
use AvtoDev\FirebaseNotificationsChannel\Receivers\FcmTopicReceiver;
use AvtoDev\FirebaseNotificationsChannel\Exceptions\CouldNotSendNotification;

/**
 * Class FcmChannelTest.
 *
 * @coversDefaultClass \AvtoDev\FirebaseNotificationsChannel\FcmChannel
 */
class FcmChannelTest extends AbstractTestCase
{
    /**
     * @var FcmChannel
     */
    protected $firebase_channel;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();
        $this->firebase_channel = $this->app->make(FcmChannel::class);
    }

    /**
     * Success notification sending.
     *
     * @throws \InvalidArgumentException
     * @throws CouldNotSendNotification
     */
    public function testSendSuccess()
    {
        $response = new Response(200, [], \json_encode(['message_id' => 'test']));
        $this->mock_handler->append($response);

        $this->firebase_channel->send($this->getNotifiableMock(), $this->getNotificationMock());
    }

    /**
     * Check notification without "toFcm" method.
     *
     * @throws CouldNotSendNotification
     */
    public function testSendNoToFcm()
    {
        $this->expectException(CouldNotSendNotification::class);
        $this->expectExceptionMessage('Can\'t convert notification to FCM message');

        $notification = $this
            ->getMockBuilder(Notification::class)
            ->getMock();

        $this->firebase_channel->send($this->getNotifiableMock(), $notification);
    }

    /**
     * Success notification sending.
     *
     * @throws CouldNotSendNotification
     * @throws \InvalidArgumentException
     */
    public function testSendFailed()
    {
        $this->expectException(CouldNotSendNotification::class);

        $response = new Response(300, [], \json_encode(['message_id' => 'test']));
        $this->mock_handler->append($response);

        $this->firebase_channel->send($this->getNotifiableMock(), $this->getNotificationMock());
    }

    /**
     * @return Notification
     */
    protected function getNotificationMock()
    {
        $notification = $this
            ->getMockBuilder(Notification::class)
            ->setMethods(['toFcm'])
            ->getMock();

        $notification
            ->expects($this->once())
            ->method('toFcm')
            ->willReturn(
                new FcmMessage
            );

        return $notification;
    }

    /**
     * @return Notifiable
     */
    protected function getNotifiableMock()
    {
        $notifiable = $this
            ->getMockBuilder(Notifiable::class)
            ->setMethods(['routeNotificationForFcm'])
            ->getMockForTrait();

        $notifiable
            ->expects($this->once())
            ->method('routeNotificationForFcm')
            ->willReturn(
                new FcmTopicReceiver('test')
            );

        return $notifiable;
    }
}
