<?php

namespace AvtoDev\FirebaseNotificationsChannel;

use GuzzleHttp\Client;
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
     * @param        $endpoint
     */
    public function __construct(Client $http_client, $endpoint)
    {
        $this->http_client = $http_client;
        $this->endpoint = $endpoint;
    }

    /**
     * Send message to firebase cloud messaging server.
     *
     * @param FcmNotificationReceiverInterface $receiver
     * @param FcmMessage                       $message
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function sendMessage(FcmNotificationReceiverInterface $receiver, FcmMessage $message)
    {
        $message_payload = $this->filterPayload(\array_merge($receiver->getTarget(), $message->toArray()));

        return $this->http_client->post($this->endpoint, [
            'json' => [
                'message' => $message_payload,
            ],
        ]);
    }

    /**
     * Unset all empty data from payload.
     *
     * @param array $payload
     *
     * @return array
     */
    protected function filterPayload($payload)
    {
        foreach ($payload as $key => $value) {
            if ($value === null || $value === '') {
                unset($payload[$key]);
            }

            if (\is_array($value)) {
                $value = $this->filterPayload($value);
                $payload[$key] = $value;
            }

            if ($value === []) {
                unset($payload[$key]);
            }
        }

        return $payload;
    }
}
