<?php

namespace AvtoDev\FirebaseNotificationsChannel\Receivers;

class FcmDeviceReceiver implements FcmNotificationReceiverInterface
{
    /**
     * @var string
     */
    protected $token;

    /**
     * FcmDeviceReceiver constructor.
     *
     * @param string $token
     */
    public function __construct(string $token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken(): string
    {
        return $this->token;
    }

    /**
     * {@inheritdoc}
     */
    public function getTarget(): array
    {
        return ['token' => $this->getToken()];
    }
}
