<?php

namespace AvtoDev\FirebaseCloudMessaging\Test;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use AvtoDev\FirebaseCloudMessaging\FcmClient;
use AvtoDev\DevTools\Tests\PHPUnit\AbstractLaravelTestCase;

abstract class AbstractTestCase extends AbstractLaravelTestCase
{
    /**
     * @var MockHandler
     */
    protected $mock_handler;

    public function setUp()
    {
        parent::setUp();

        $this->app->bind(FcmClient::class, function () {
            $this->mock_handler = new MockHandler;

            $handler = HandlerStack::create($this->mock_handler);

            $http_client = new Client(['handler' => $handler]);

            return new FcmClient(
                $http_client,
                'https://fcm.googleapis.com/v1/projects/'.config('fcm.project_id').'/messages:send'
            );
        });
    }

    public function tearDown()
    {
        \Mockery::close();
        parent::tearDown();
    }
}
