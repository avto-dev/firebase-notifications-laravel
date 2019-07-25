<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel\Tests;

use GuzzleHttp\Psr7\Response;
use AvtoDev\FirebaseNotificationsChannel\FcmClient;
use AvtoDev\FirebaseNotificationsChannel\FcmMessage;
use Tarampampam\Wrappers\Exceptions\JsonEncodeDecodeException;
use Tarampampam\Wrappers\Frameworks\Laravel5\Facades\Json;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use AvtoDev\FirebaseNotificationsChannel\Receivers\FcmDeviceReceiver;
use AvtoDev\FirebaseNotificationsChannel\Exceptions\CouldNotSendNotification;

/**
 * @coversDefaultClass \AvtoDev\FirebaseNotificationsChannel\FcmClient
 */
class FcmClientTest extends AbstractTestCase
{
    /**
     * @var FcmClient
     */
    protected $firebase_client;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->firebase_client = $this->app->make(FcmClient::class);
    }

    /**
     * @covers ::sendMessage()
     *
     * @throws CouldNotSendNotification
     * @throws InvalidArgumentException
     * @throws JsonEncodeDecodeException
     * @throws \InvalidArgumentException
     */
    public function testSendMessage(): void
    {
        $response = new Response(200, [], Json::encode(['message_id' => 'test']));
        $this->mock_handler->append($response);

        $r = $this->firebase_client->sendMessage(new FcmDeviceReceiver('test'), new FcmMessage);
        $this->assertJson((string) $r->getBody());
    }

    /**
     * @covers ::sendMessage()
     *
     * @throws CouldNotSendNotification
     * @throws \InvalidArgumentException
     */
    public function testSendMessageException(): void
    {
        $this->expectException(CouldNotSendNotification::class);

        $response = new Response(418, [], 'Test message');
        $this->mock_handler->append($response);

        $this->firebase_client->sendMessage(new FcmDeviceReceiver('test'), new FcmMessage);
    }

    /**
     * @covers ::filterPayload()
     *
     * @throws CouldNotSendNotification
     * @throws InvalidArgumentException
     * @throws JsonEncodeDecodeException
     * @throws \InvalidArgumentException
     */
    public function testFilterPayloadForRemoveEmptyValue(): void
    {

        $this->mock_handler->append(new Response);
        $unfiltered_payload = [
            'message' => [
                'token'        => 'some',
                'data'         => [
                    'foo' => 'bar',
                ],
                'notification' => [
                    'title' => 'some',
                ],
                'apns'         => [
                    'payload' => [
                        'aps' => [
                            'mutable-content' => 0,
                        ],
                    ],
                ],
            ],
        ];

        $fcm_message = new FcmMessage;

        $fcm_message->setTitle('some');
        $fcm_message->setData([
            'foo' => 'bar',
        ]);

        $this->firebase_client->sendMessage(new FcmDeviceReceiver('some'), $fcm_message);

        $filtered_payload = Json::decode($this->mock_handler->getLastRequest()->getBody()->getContents());

        $this->mock_handler->getLastRequest()->getBody()->getContents();

        $this->assertEquals($unfiltered_payload, $filtered_payload);
    }

    /**
     * @covers ::__construct()
     *
     * @throws InvalidArgumentException
     * @throws \InvalidArgumentException
     */
    public function testConstructor(): void
    {
        $endpoint = 'test';
        $this->mock_handler->append(new Response);

        $client = new FcmClient($this->http_client, $endpoint);
        $client->sendMessage(new FcmDeviceReceiver(''), new FcmMessage);

        self::assertEquals($endpoint, $this->mock_handler->getLastRequest()->getUri());
    }
}
