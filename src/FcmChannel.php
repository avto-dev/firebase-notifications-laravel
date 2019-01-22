<?php

namespace AvtoDev\FirebaseCloudMessaging;

use Illuminate\Notifications\Notification;
use AvtoDev\FirebaseCloudMessaging\Exceptions\CouldNotSendNotification;
use AvtoDev\FirebaseCloudMessaging\Receivers\FcmNotificationReceiverInterface;

/**
 * Channel to send message to Firebase cloud message.
 */
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
     * @param mixed                                  $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @throws CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        $route_notification_for_fcm = $notifiable->routeNotificationFor('fcm', $notification);

        if (! ($route_notification_for_fcm instanceof FcmNotificationReceiverInterface)) {
            return;
        }

        if (! \method_exists($notification, 'toFcm')) {
            throw CouldNotSendNotification::invalidNotification();
        }

        $response = $this->fcm_client->sendMessage(
            $route_notification_for_fcm,
            $notification->toFcm()
        );

        if ($response->getStatusCode() !== 200) {
            throw new CouldNotSendNotification((string) $response->getBody());
        }
    }
}
