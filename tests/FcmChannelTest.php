<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use PHPUnit\Framework\MockObject\MockObject;
use AvtoDev\FirebaseNotificationsChannel\FcmClient;
use AvtoDev\FirebaseNotificationsChannel\FcmChannel;
use AvtoDev\FirebaseNotificationsChannel\FcmMessage;
use AvtoDev\FirebaseNotificationsChannel\Receivers\FcmTopicReceiver;
use AvtoDev\FirebaseNotificationsChannel\Receivers\FcmDeviceReceiver;
use AvtoDev\FirebaseNotificationsChannel\Exceptions\CouldNotSendNotification;

/**
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
    protected function setUp(): void
    {
        parent::setUp();

        $this->firebase_channel = $this->app->make(FcmChannel::class);
    }

    /**
     * @covers ::__construct()
     */
    public function testConstruct(): void
    {
        $this->expectException(CouldNotSendNotification::class);

        $notification = new class extends Notification {
            public function toFcm()
            {
                return new FcmMessage;
            }
        };

        $receiver = new class {
            public function routeNotificationFor($target)
            {
                return new FcmDeviceReceiver('awd');
            }
        };

        $this->mock_handler->append(new Response(418, [], 'This test message'));
        $this->firebase_channel->send($receiver, $notification);
    }

    /**
     * Success notification sending.
     *
     * @covers ::send()
     */
    public function testSendSuccess(): void
    {
        $response = new Response(200, [], json_encode(['message_id' => 'test']));
        $this->mock_handler->append($response);

        $this->firebase_channel->send($this->getNotifiableMock(), $this->getNotificationMock());
    }

    /**
     * Check notification without "toFcm" method.
     *
     * @covers ::send()
     */
    public function testSendNoToFcm(): void
    {
        $this->expectException(CouldNotSendNotification::class);
        $this->expectExceptionMessage('Can\'t convert notification to FCM message');

        /** @var Notification $notification */
        $notification = $this
            ->getMockBuilder(Notification::class)
            ->getMock();

        $this->firebase_channel->send($this->getNotifiableMock(), $notification);
    }

    /**
     * @covers ::send()
     */
    public function testSendFailed(): void
    {
        $this->expectException(CouldNotSendNotification::class);

        $response = new Response(300, [], json_encode(['message_id' => 'test']));
        $this->mock_handler->append($response);

        $this->firebase_channel->send($this->getNotifiableMock(), $this->getNotificationMock());
    }

    /**
     * @covers ::send()
     */
    public function testNoSend(): void
    {
        $history_container = [];

        $stack = HandlerStack::create();
        // Add the history middleware to the handler stack.
        $stack->push(Middleware::history($history_container));

        $fcm_channel = new FcmChannel(
            new FcmClient(
                new Client(['handler' => $stack]),
                ''
            )
        );

        $fcm_channel->send(
            $this
                ->getMockBuilder(Notifiable::class)
                ->addMethods(['routeNotificationForFcm'])
                ->getMockForTrait(),
            $this
                ->getMockBuilder(Notification::class)
                ->addMethods(['toFcm'])
                ->getMock()
        );

        $this->assertCount(0, $history_container);
    }

    /**
     * @return MockObject|Notifiable
     */
    protected function getNotificationMock()
    {
        $notification = $this
            ->getMockBuilder(Notification::class)
            ->addMethods(['toFcm'])
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
     * @return MockObject|Notifiable
     */
    protected function getNotifiableMock()
    {
        $notifiable = $this
            ->getMockBuilder(Notifiable::class)
            ->addMethods(['routeNotificationForFcm'])
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
