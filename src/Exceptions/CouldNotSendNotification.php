<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel\Exceptions;

final class CouldNotSendNotification extends \Exception
{
    /**
     * @return static
     */
    public static function invalidNotification(): self
    {
        return new static('Can\'t convert notification to FCM message');
    }
}
