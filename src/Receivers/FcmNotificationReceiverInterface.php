<?php

namespace AvtoDev\FirebaseNotificationsChannel\Receivers;

interface FcmNotificationReceiverInterface
{
    /**
     * Get target (token or topic).
     *
     * @return array
     */
    public function getTarget(): array;
}
