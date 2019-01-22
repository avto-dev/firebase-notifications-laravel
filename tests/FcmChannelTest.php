<?php

namespace AvtoDev\FirebaseCloudMessaging\Test;

use GuzzleHttp\Psr7\Response;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use AvtoDev\FirebaseCloudMessaging\FcmChannel;
use AvtoDev\FirebaseCloudMessaging\FcmMessage;
use AvtoDev\FirebaseCloudMessaging\Receivers\FcmTopicReceiver;
use AvtoDev\FirebaseCloudMessaging\Exceptions\CouldNotSendNotification;

/**
 * Class FcmChannelTest.
 *
 * @coversDefaultClass \AvtoDev\FirebaseCloudMessaging\FcmChannel
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
     */
    public function testSendSuccess()
    {
        $response = new Response(200, [], \json_encode(['message_id' => 'test']));
        $this->mock_handler->append($response);

        $this->firebase_channel->send($this->getNotifiableMock(), $this->getNotificationMock());
    }

    /**
     * Check notification without "toFcm" method.
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
