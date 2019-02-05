<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel\Exceptions;

class CouldNotSendNotification extends \Exception
{
    public static function invalidNotification()
    {
        return new self('Can\'t convert notification to FCM message');
    }
}
