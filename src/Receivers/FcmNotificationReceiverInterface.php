<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel\Receivers;

interface FcmNotificationReceiverInterface
{
    /**
     * Get target (token or topic).
     *
     * @return array<string, string>
     */
    public function getTarget(): array;
}
