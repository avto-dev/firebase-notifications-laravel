<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel;

use Illuminate\Notifications\Notification;
use AvtoDev\FirebaseNotificationsChannel\Exceptions\CouldNotSendNotification;
use AvtoDev\FirebaseNotificationsChannel\Receivers\FcmNotificationReceiverInterface;

class FcmChannel
{
    /**
     * @var FcmClient
     */
    protected $fcm_client;

    /**
     * FcmChannel constructor.
     *
     * @param FcmClient $fcm_client
     */
    public function __construct(FcmClient $fcm_client)
    {
        $this->fcm_client = $fcm_client;
    }

    /**
     * Send the given notification.
     *
     * @param mixed        $notifiable
     * @param Notification $notification
     *
     * @throws CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification): void
    {
        /** @var object $notifiable */
        if (! \method_exists($notifiable, 'routeNotificationFor')) {
            return;
        }
        $route_notification_for_fcm = $notifiable->routeNotificationFor('fcm', $notification);

        if (! ($route_notification_for_fcm instanceof FcmNotificationReceiverInterface)) {
            return;
        }

        if (! \method_exists($notification, $method_name = 'toFcm')) {
            throw CouldNotSendNotification::invalidNotification();
        }

        $response = $this->fcm_client->sendMessage(
            $route_notification_for_fcm,
            $notification->{$method_name}($notifiable)
        );

        if ($response->getStatusCode() !== 200) {
            throw new CouldNotSendNotification((string) $response->getBody());
        }
    }
}
