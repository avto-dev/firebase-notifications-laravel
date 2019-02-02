<?php

namespace AvtoDev\FirebaseNotificationsChannel;

use Illuminate\Contracts\Support\Arrayable;
use AvtoDev\FirebaseNotificationsChannel\PlatformSettings\AppleFcmPlatformSettings;
use AvtoDev\FirebaseNotificationsChannel\PlatformSettings\AndroidFcmPlatformSettings;
use AvtoDev\FirebaseNotificationsChannel\PlatformSettings\WebpushFcmPlatformSettings;

/**
 * Message object contains all supported data and settings.
 */
class FcmMessage implements Arrayable
{
    /**
     * @var array
     */
    protected $data;

    /**
     * Android specific options for messages sent through FCM connection server.
     *
     * @var AndroidFcmPlatformSettings
     */
    protected $android;

    /**
     * Webpush protocol options.
     *
     * @var WebpushFcmPlatformSettings
     */
    protected $webpush;

    /**
     * Apple Push Notification Service specific options.
     *
     * @var AppleFcmPlatformSettings
     */
    protected $apns;

    /**
     * The notification's title.
     *
     * @var string
     */
    protected $title;

    /**
     * The notification's body text.
     *
     * @var string
     */
    protected $body;

    /**
     * FcmMessage constructor.
     */
    public function __construct()
    {
        $this->android = new AndroidFcmPlatformSettings;
        $this->webpush = new WebpushFcmPlatformSettings;
        $this->apns    = new AppleFcmPlatformSettings;
    }

    /**
     * @return WebpushFcmPlatformSettings
     */
    public function getWebpush()
    {
        return $this->webpush;
    }

    /**
     * @param WebpushFcmPlatformSettings $webpush
     */
    public function setWebpush(WebpushFcmPlatformSettings $webpush)
    {
        $this->webpush = $webpush;
    }

    /**
     * @return AppleFcmPlatformSettings
     */
    public function getApns()
    {
        return $this->apns;
    }

    /**
     * @param AppleFcmPlatformSettings $apns
     */
    public function setApns(AppleFcmPlatformSettings $apns)
    {
        $this->apns = $apns;
    }

    /**
     * Arbitrary key/value payload.
     *
     * An object containing a list of key-value pairs
     *
     * @example ['name'=>'wrench','mass'=>'1.3kg','count'=>3]
     *
     * @param array $data
     *
     * @return $this
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * The notification's title.
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * The notification's body text.
     *
     * @param string $body
     *
     * @return $this
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @return AndroidFcmPlatformSettings
     */
    public function getAndroid()
    {
        return $this->android;
    }

    /**
     * @param AndroidFcmPlatformSettings $android
     */
    public function setAndroid(AndroidFcmPlatformSettings $android)
    {
        $this->android = $android;
    }

    /**
     * Build an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'data'         => $this->data,
            'notification' => [
                'title' => $this->title,
                'body'  => $this->body,
            ],
            'android'      => $this->android->toArray(),
            'webpush'      => $this->webpush->toArray(),
            'apns'         => $this->apns->toArray(),
        ];
    }
}
