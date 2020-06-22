<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel\Tests;

use Google_Client;
use GuzzleHttp\Client;
use Tarampampam\Wrappers\Json;
use GuzzleHttp\ClientInterface;
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
     * @var Google_Client
     */
    protected $google_client_stub;

    /**
     * {@inheritdoc}
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->google_client_stub = $google_client_stub = new class extends Google_Client {
            public $credentials;

            public $scope;

            public function setAuthConfig($credentials)
            {
                $this->credentials = $credentials;
            }

            public function addScope($scope)
            {
                $this->scope = $scope;
            }

            public function authorize(ClientInterface $http = null)
            {
                return new Client;
            }
        };

        $this->app->bind(Google_Client::class, static function () use ($google_client_stub) {
            return $google_client_stub;
        });

        $this->service_provider = new ServiceProvider($this->app);
    }

    /**
     * @covers ::getCredentials()
     * @covers ::register()
     */
    public function testGetCredentialsFromFile(): void
    {
        $this->setUpConfigFile();

        $this->service_provider->register();
        $this->app->make(FcmChannel::class);

        $this->assertEquals(
            Json::decode(\file_get_contents(__DIR__ . '/Stubs/firebase.json')),
            $this->google_client_stub->credentials
        );
    }

    /**
     * @covers ::getCredentials()
     * @covers ::register()
     */
    public function testGetCredentialsFileNotFound(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('file does not exist');

        $this->setUpConfigFile('');
        $this->service_provider->register();
        $this->app->make(FcmChannel::class);
    }

    /**
     * @covers ::getCredentials()
     * @covers ::register()
     */
    public function testGetCredentialsFromFileInvalidJson(): void
    {
        $this->expectException(JsonEncodeDecodeException::class);
        $this->setUpConfigFile(__DIR__ . '/Stubs/invalid_firebase.json');
        $this->service_provider->register();
        $this->app->make(FcmChannel::class);
    }

    /**
     * @covers ::getCredentials()
     * @covers ::register()
     */
    public function testGetCredentialsFromConfig(): void
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $this->app->make('config');

        $config->set('services.fcm.driver', 'config');

        $this->service_provider->register();
        $this->app->make(FcmChannel::class);

        $this->assertEquals(
            $config->get('services.fcm.drivers.config.credentials', []),
            $this->google_client_stub->credentials
        );
    }

    /**
     * @covers ::getCredentials()
     * @covers ::register()
     */
    public function testGetCredentialsDriverNotSet(): void
    {
        /** @var \Illuminate\Config\Repository $config */
        $config = $this->app->make('config');
        $config->set('services.fcm.driver', '');
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Fcm driver not set');

        $this->service_provider->register();
        $this->app->make(FcmChannel::class);
    }

    /**
     * @param null|string $path
     */
    protected function setUpConfigFile($path = null): void
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
