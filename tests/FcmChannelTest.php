<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Illuminate\Notifications\Notifiable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use AvtoDev\FirebaseNotificationsChannel\FcmClient;
use AvtoDev\FirebaseNotificationsChannel\FcmChannel;
use AvtoDev\FirebaseNotificationsChannel\FcmMessage;
use AvtoDev\FirebaseNotificationsChannel\Receivers\FcmTopicReceiver;
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
    public function setUp(): void
    {
        parent::setUp();
        $this->firebase_channel = $this->app->make(FcmChannel::class);
    }

    /**
     * @covers ::__construct()
     *
     * @throws \ReflectionException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testConstruct(): void
    {
        self::assertInstanceOf(FcmClient::class, self::getProperty($this->firebase_channel, 'fcm_client'));
    }

    /**
     * Success notification sending.
     *
     * @covers ::send()
     *
     * @throws \InvalidArgumentException
     * @throws CouldNotSendNotification
     */
    public function testSendSuccess(): void
    {
        $response = new Response(200, [], \json_encode(['message_id' => 'test']));
        $this->mock_handler->append($response);
        $notification = new class extends Notification implements ShouldQueue {
        };
        $this->firebase_channel->send($this->getNotifiableMock(), $this->getNotificationMock());
    }

    /**
     * Check notification without "toFcm" method.
     *
     * @covers ::send()
     *
     * @throws CouldNotSendNotification
     */
    public function testSendNoToFcm(): void
    {
        $this->expectException(CouldNotSendNotification::class);
        $this->expectExceptionMessage('Can\'t convert notification to FCM message');

        $notification = $this
            ->getMockBuilder(Notification::class)
            ->getMock();

        $this->firebase_channel->send($this->getNotifiableMock(), $notification);
    }

    /**
     * @covers ::send()
     *
     * @throws CouldNotSendNotification
     * @throws \InvalidArgumentException
     */
    public function testSendFailed(): void
    {
        $this->expectException(CouldNotSendNotification::class);

        $response = new Response(300, [], \json_encode(['message_id' => 'test']));
        $this->mock_handler->append($response);

        $this->firebase_channel->send($this->getNotifiableMock(), $this->getNotificationMock());
    }

    /**
     * @covers ::send()
     *
     * @throws CouldNotSendNotification
     * @throws \InvalidArgumentException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
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
                ->setMethods(['routeNotificationForFcm'])
                ->getMockForTrait(),
            $this
                ->getMockBuilder(Notification::class)
                ->setMethods(['toFcm'])
                ->getMock()
        );

        self::assertCount(0, $history_container);
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
