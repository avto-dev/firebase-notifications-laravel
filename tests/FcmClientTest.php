<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use AvtoDev\FirebaseNotificationsChannel\FcmClient;
use AvtoDev\FirebaseNotificationsChannel\FcmMessage;
use SebastianBergmann\RecursionContext\InvalidArgumentException;
use AvtoDev\FirebaseNotificationsChannel\Receivers\FcmDeviceReceiver;

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
     * @throws \InvalidArgumentException
     */
    public function testSendMessage(): void
    {
        $response = new Response(200, [], \json_encode(['message_id' => 'test']));
        $this->mock_handler->append($response);

        $r = $this->firebase_client->sendMessage(new FcmDeviceReceiver('test'), new FcmMessage);
        $this->assertJson((string) $r->getBody());
    }

    /**
     * @covers ::filterPayload()
     *
     * @throws \ReflectionException
     * @throws InvalidArgumentException
     */
    public function testFilterPayloadForRemoveEmptyValue(): void
    {
        $unfiltered_payload = [
            'foo'   => 'bar',
            'array' => [
                'foo' => 'bar',
            ],
        ];

        $values_to_remove = [
            'array'       => [
                'empty_value' => '',
                'null_value'  => null,
                'empty_array' => [],
            ],
            'empty_value' => '',
            'null_value'  => null,
            'empty_array' => [],
        ];

        $filtered_payload = $this->callMethod(
            $this->firebase_client,
            'filterPayload',
            [\array_merge_recursive($unfiltered_payload, $values_to_remove)]
        );

        $this->assertEquals($unfiltered_payload, $filtered_payload);
    }

    /**
     * @covers ::__construct()
     *
     * @throws InvalidArgumentException
     * @throws \InvalidArgumentException
     * @throws \ReflectionException
     */
    public function testConstructor(): void
    {
        $http_client = new Client;
        $endpoint    = 'test';
        $client      = new FcmClient($http_client, $endpoint);

        $this->assertEquals($endpoint, $this->getObjectAttribute($client, 'endpoint'));
        $this->assertEquals($http_client, $this->getObjectAttribute($client, 'http_client'));
    }
}
