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

        $credentials = ['type'                        => 'service_account',
                        'project_id'                  => 'test',
                        'private_key_id'              => 'da80b3bbceaa554442ad67e6be361a66',
                        'private_key'                 => '-----BEGIN PRIVATE KEY-----\nQXJlIHlvdSByZWFseSB0aGluayBhJ20gc28gc3R1cGlkIHRvIGdpd\nmUgeW91IHJlYWwgcHJpdmF0ZSBrZXk/Ck5PISBJdCdzIGp1c3QgY\nSBmaWN0aW9uIGFuZCB0aGlzIG1lc3NhZ2UgaXMgdG8gc2hvcnQ=\n-----END PRIVATE KEY-----\n',
                        'client_email'                => 'firebase-adminsdk-mwax6@test.iam.gserviceaccount.com',
                        'client_id'                   => '22021520333507180281',
                        'auth_uri'                    => 'https://accounts.google.com/o/oauth2/auth',
                        'token_uri'                   => 'https://oauth2.googleapis.com/token',
                        'auth_provider_x509_cert_url' => 'https://www.googleapis.com/oauth2/v1/certs',
                        'client_x509_cert_url'        => 'https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-mwax6%40test.iam.gserviceaccount.com',
        ];

        $config->set('services.fcm.credentials', $credentials);
        self::assertEquals(
            $credentials,
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
            self::getProperty($fcm_client,
                'endpoint')
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
        $config->set('services.fcm.file', $path);
    }
}
