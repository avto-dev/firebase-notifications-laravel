<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel;

use Google_Client;
use GuzzleHttp\Client;
use InvalidArgumentException;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Config\Repository as ConfigRepository;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register the package services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app
            ->when(FcmChannel::class)
            ->needs(FcmClient::class)
            ->give(function (Container $app) {
                /** @var ConfigRepository $config */
                $config = $app->make(ConfigRepository::class);

                $credentials = $this->getCredentials($config);

                /** @var Google_Client $google_client */
                $google_client = $app->make(Google_Client::class);
                $google_client->setAuthConfig($credentials);
                $google_client->addScope('https://www.googleapis.com/auth/firebase.messaging');

                /** @var Client $http_client Guzzle http-client with google-auth middleware */
                $http_client = $google_client->authorize();

                return new FcmClient(
                    $http_client,
                    'https://fcm.googleapis.com/v1/projects/' . $credentials['project_id'] . '/messages:send'
                );
            });
    }

    /**
     * Get Fcm credentials.
     *
     * @param ConfigRepository $config
     *
     * @throws \JsonException
     *
     * @throws InvalidArgumentException  If credentials file is missing or FCM driver was not set
     *
     * @return array<string, string|integer>
     */
    protected function getCredentials(ConfigRepository $config): array
    {
        $config_driver = $config->get('services.fcm.driver');

        if ($config_driver === 'file') {
            /** @var string $credentials_path */
            $credentials_path = $config->get('services.fcm.drivers.file.path', '');

            if (! \file_exists($credentials_path)) {
                throw new InvalidArgumentException('file does not exist');
            }

            $credentials = (array) \json_decode((string) \file_get_contents($credentials_path), true, 512,
                JSON_THROW_ON_ERROR);
        } elseif ($config_driver === 'config') {
            $credentials = (array) $config->get('services.fcm.drivers.config.credentials', []);
        } else {
            throw new InvalidArgumentException('Fcm driver not set');
        }

        /** @var array<string, integer|string> */
        return $credentials;
    }
}
