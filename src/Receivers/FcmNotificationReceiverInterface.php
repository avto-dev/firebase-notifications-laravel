<?php

declare(strict_types = 1);

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
