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
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * {@inheritdoc}
     */
    public function getTarget()
    {
        return ['token' => $this->getToken()];
    }
}
