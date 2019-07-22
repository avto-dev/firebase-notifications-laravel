<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel\Tests;

use ReflectionClass;
use GuzzleHttp\Client;
use ReflectionException;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Handler\MockHandler;
use Illuminate\Contracts\Console\Kernel;
use AvtoDev\FirebaseNotificationsChannel\FcmClient;
use AvtoDev\FirebaseNotificationsChannel\ServiceProvider;

abstract class AbstractTestCase extends \Illuminate\Foundation\Testing\TestCase
{
    /**
     * @var MockHandler
     */
    protected $mock_handler;

    /**
     * {@inheritdoc}
     */
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

    /**
     * {@inheritdoc}
     */
    public function tearDown(): void
    {
        \Mockery::close(); // @todo: delete this

        parent::tearDown();
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

    /**
     * Calls a instance method (public/private/protected) by its name.
     *
     * @param object $object
     * @param string $method_name
     * @param array  $args
     *
     * @throws ReflectionException
     *
     * @return mixed
     */
    protected function callMethod($object, string $method_name, array $args = [])
    {
        $class = new ReflectionClass($object);

        $method = $class->getMethod($method_name);
        $method->setAccessible(true);

        return $method->invokeArgs($object, $args);
    }
}
