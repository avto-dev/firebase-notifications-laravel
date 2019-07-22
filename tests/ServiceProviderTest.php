<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel\Tests;

use Tarampampam\Wrappers\Json;
use AvtoDev\FirebaseNotificationsChannel\FcmClient;
use AvtoDev\FirebaseNotificationsChannel\FcmChannel;
use AvtoDev\FirebaseNotificationsChannel\ServiceProvider;
use Tarampampam\Wrappers\Exceptions\JsonEncodeDecodeException;

/**
 * @coversDefaultClass \AvtoDev\FirebaseNotificationsChannel\ServiceProvider
 */
class ServiceProviderTest extends AbstractTestCase
{
    /**
     * @var ServiceProvider
     */
    protected $service_provider;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->app->make('config')->set('services', require __DIR__ . '/config/services.php');
        $this->service_provider = new ServiceProvider($this->app);
    }

    /**
     * @covers ::getCredentials()
     *
     * @throws JsonEncodeDecodeException
     * @throws \ReflectionException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testGetCredentialsFromFile(): void
    {
        $this->setUpConfigFile();
        $this->assertEquals(
            Json::decode(\file_get_contents(__DIR__ . '/Stubs/firebase.json')),
            $this->callMethod($this->service_provider, 'getCredentials', [$this->app])
        );
    }

    /**
     * @covers ::getCredentials()
     *
     * @throws \ReflectionException
     */
    public function testGetCredentialsFileNotFound(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('file does not exist');

        $this->setUpConfigFile('');
        $this->callMethod($this->service_provider, 'getCredentials', [$this->app]);
    }

    /**
     * @covers ::getCredentials()
     *
     * @throws \ReflectionException
     */
    public function testGetCredentialsFromFileInvalidJson(): void
    {
        $this->expectException(JsonEncodeDecodeException::class);
        $this->setUpConfigFile(__DIR__ . '/Stubs/invalid_firebase.json');
        $this->callMethod($this->service_provider, 'getCredentials', [$this->app]);
    }

    /**
     * @covers ::getCredentials()
     *
     * @throws \ReflectionException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testGetCredentialsFromConfig(): void
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $this->app->make('config');

        $config->set('services.fcm.driver', 'config');

        $this->assertEquals(
            $config->get('services.fcm.drivers.config.credentials', []),
            $this->callMethod($this->service_provider, 'getCredentials', [$this->app])
        );
    }

    /**
     * @covers ::getCredentials()
     *
     * @throws \ReflectionException
     */
    public function testGetCredentialsDriverNotSet(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Fcm driver not set');

        $this->callMethod($this->service_provider, 'getCredentials', [$this->app]);
    }

    /**
     * @covers ::boot()
     *
     * @throws \ReflectionException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testBoot(): void
    {
        $this->setUpConfigFile();
        $this->service_provider->boot();

        $fcm_channel = $this->app->make(FcmChannel::class);

        /** @var FcmClient $fcm_client */
        $fcm_client = $this->getObjectAttribute($fcm_channel, 'fcm_client');

        $this->assertContains(
            'https://fcm.googleapis.com/v1/projects/test/messages:send',
            $this->getObjectAttribute($fcm_client, 'endpoint')
        );
    }

    protected function setUpConfigFile($path = null)
    {
        if ($path === null) {
            $path = __DIR__ . '/Stubs/firebase.json';
        }

        /** @var \Illuminate\Config\Repository $config */
        $config = $this->app->make('config');

        $config->set('services.fcm.driver', 'file');
        $config->set('services.fcm.drivers.file.path', $path);
    }
}
