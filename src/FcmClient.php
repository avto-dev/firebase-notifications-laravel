<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use AvtoDev\FirebaseNotificationsChannel\Exceptions\CouldNotSendNotification;
use AvtoDev\FirebaseNotificationsChannel\Receivers\FcmNotificationReceiverInterface;

class FcmClient
{
    /**
     * @var Client
     */
    protected $http_client;

    /**
     * @var string
     */
    protected $endpoint;

    /**
     * FcmClient constructor.
     *
     * @param Client $http_client
     * @param string $endpoint
     */
    public function __construct(Client $http_client, string $endpoint)
    {
        $this->http_client = $http_client;
        $this->endpoint    = $endpoint;
    }

    /**
     * Send message to firebase cloud messaging server.
     *
     * @param FcmNotificationReceiverInterface $receiver
     * @param FcmMessage                       $message
     *
     * @return \Psr\Http\Message\ResponseInterface
     *
     * @throws CouldNotSendNotification
     */
    public function sendMessage(FcmNotificationReceiverInterface $receiver, FcmMessage $message)
    {
        $message_payload = $this->filterPayload(\array_merge($receiver->getTarget(), $message->toArray()));

        try {
            return $this->http_client->post($this->endpoint, [
                'json' => [
                    'message' => $message_payload,
                ],
            ]);
        } catch (GuzzleException $e) {
            throw new CouldNotSendNotification($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * Unset all empty data from payload.
     *
     * @param array $payload
     *
     * @return array
     */
    protected function filterPayload(array $payload): array
    {
        foreach ($payload as $key => $value) {
            if ($value === null || $value === '') {
                unset($payload[$key]);
            }

            if (\is_array($value)) {
                $value         = $this->filterPayload($value);
                $payload[$key] = $value;
            }

            if ($value === []) {
                unset($payload[$key]);
            }
        }

        return $payload;
    }
}
