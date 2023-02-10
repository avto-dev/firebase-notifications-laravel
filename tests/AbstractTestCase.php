<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase;
use AvtoDev\FirebaseNotificationsChannel\FcmClient;
use AvtoDev\FirebaseNotificationsChannel\FcmChannel;
use AvtoDev\FirebaseNotificationsChannel\ServiceProvider;

abstract class AbstractTestCase extends TestCase
{
    /**
     * @var MockHandler
     */
    protected $mock_handler;

    /**
     * @var Client
     */
    protected $http_client;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->mock_handler = new MockHandler;

        $handler = HandlerStack::create($this->mock_handler);

        $this->http_client = $http_client = new Client(['handler' => $handler]);

        $binding = static function () use ($http_client) {
            return new FcmClient(
                $http_client,
                'https://fcm.googleapis.com/v1/projects/' . config('fcm.project_id') . '/messages:send'
            );
        };

        $this->app->bind(FcmClient::class, $binding);

        $this->app
            ->when(FcmChannel::class)
            ->needs(FcmClient::class)
            ->give($binding);
    }

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = require __DIR__ . '/../vendor/laravel/laravel/bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $app->make('config')->set('services', require __DIR__ . '/config/services.php');

        $app->register(ServiceProvider::class);

        return $app;
    }
}
