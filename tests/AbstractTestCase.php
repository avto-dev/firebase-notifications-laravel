<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use AvtoDev\FirebaseNotificationsChannel\FcmClient;
use AvtoDev\DevTools\Tests\PHPUnit\AbstractLaravelTestCase;

abstract class AbstractTestCase extends AbstractLaravelTestCase
{
    /**
     * @var MockHandler
     */
    protected $mock_handler;

    public function setUp(): void
    {
        parent::setUp();

        $this->app->bind(FcmClient::class, function () {
            $this->mock_handler = new MockHandler;

            $handler = HandlerStack::create($this->mock_handler);

            $http_client = new Client(['handler' => $handler]);

            return new FcmClient(
                $http_client,
                'https://fcm.googleapis.com/v1/projects/' . config('fcm.project_id') . '/messages:send'
            );
        });
    }

    public function tearDown(): void
    {
        \Mockery::close();

        parent::tearDown();
    }
}
