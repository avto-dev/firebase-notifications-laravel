<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel;

use Google_Client;
use GuzzleHttp\Client;
use Tarampampam\Wrappers\Json;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tarampampam\Wrappers\Exceptions\JsonEncodeDecodeException;

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
                $credentials = $this->getCredentials($app);

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
     * @param Container $app
     *
     * @throws JsonEncodeDecodeException
     * @throws BindingResolutionException
     * @throws \InvalidArgumentException
     * @throws \LogicException
     *
     * @return array
     */
    protected function getCredentials(Container $app): array
    {
        /** @var \Illuminate\Config\Repository $config */
        $config        = $app->make('config');
        $config_driver = $config->get('services.fcm.driver');

        if ($config_driver === 'file') {
            $credentials_path = $config->get('services.fcm.drivers.file.path', '');

            if (! \file_exists($credentials_path)) {
                throw new \InvalidArgumentException('file does not exist');
            }

            $credentials = (array) Json::decode((string) \file_get_contents($credentials_path));
        } elseif ($config_driver === 'config') {
            $credentials = (array) $config->get('services.fcm.drivers.config.credentials', []);
        } else {
            throw new \InvalidArgumentException('Fcm driver not set');
        }

        return $credentials;
    }
}
