<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel\Tests;

use Tarampampam\Wrappers\Json;
use AvtoDev\FirebaseNotificationsChannel\FcmClient;
use AvtoDev\FirebaseNotificationsChannel\FcmChannel;
use AvtoDev\FirebaseNotificationsChannel\FcmServiceProvider;
use Tarampampam\Wrappers\Exceptions\JsonEncodeDecodeException;

/**
 * @coversDefaultClass \AvtoDev\FirebaseNotificationsChannel\FcmServiceProvider
 */
class FcmServiceProviderTest extends AbstractTestCase
{
    /**
     * @var FcmServiceProvider
     */
    protected $service_provider;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        parent::setUp();
        $this->service_provider = new FcmServiceProvider($this->app);

        $stub_config = require __DIR__ . '/config/services.php';

        $this->app->make('config')->set('services', $stub_config);
    }

    /**
     * @covers ::getCredentials()
     *
     * @throws JsonEncodeDecodeException
     * @throws \ReflectionException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testGetCredentialsFromFile()
    {
        $this->setUpConfigFile();
        self::assertEquals(
            Json::decode(\file_get_contents(__DIR__ . '/Stubs/firebase.json')),
            self::callMethod($this->service_provider, 'getCredentials', [$this->app])
        );
    }

    /**
     * @covers ::getCredentials()
     *
     * @throws \ReflectionException
     */
    public function testGetCredentialsFileNotFound()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('file does not exist');

        $this->setUpConfigFile('');
        self::callMethod($this->service_provider, 'getCredentials', [$this->app]);
    }

    /**
     * @covers ::getCredentials()
     *
     * @throws \ReflectionException
     */
    public function testGetCredentialsFromFileInvalidJson()
    {
        $this->expectException(JsonEncodeDecodeException::class);
        $this->setUpConfigFile(__DIR__ . '/Stubs/invalid_firebase.json');
        self::callMethod($this->service_provider, 'getCredentials', [$this->app]);
    }

    /**
     * @covers ::getCredentials()
     *
     * @throws \ReflectionException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testGetCredentialsFromConfig()
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $this->app->make('config');

        $config->set('services.fcm.driver', 'config');

        self::assertEquals(
            $config->get('services.fcm.drivers.config.credentials', []),
            self::callMethod($this->service_provider, 'getCredentials', [$this->app])
        );
    }

    /**
     * @covers ::getCredentials()
     *
     * @throws \ReflectionException
     */
    public function testGetCredentialsDriverNotSet()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Fcm driver not set');

        self::callMethod($this->service_provider, 'getCredentials', [$this->app]);
    }

    /**
     * @covers ::boot()
     *
     * @throws \ReflectionException
     * @throws \SebastianBergmann\RecursionContext\InvalidArgumentException
     */
    public function testBoot()
    {
        $this->setUpConfigFile();
        $this->service_provider->boot();

        $fcm_channel = $this->app->make(FcmChannel::class);

        /** @var FcmClient $fcm_client */
        $fcm_client = self::getProperty($fcm_channel, 'fcm_client');

        self::assertContains(
            'https://fcm.googleapis.com/v1/projects/test/messages:send',
            self::getProperty($fcm_client, 'endpoint')
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
