<?php

namespace AvtoDev\FirebaseNotificationsChannel;

use Illuminate\Contracts\Support\Arrayable;
use AvtoDev\FirebaseNotificationsChannel\PlatformSettings\AppleFcmPlatformSettings;
use AvtoDev\FirebaseNotificationsChannel\PlatformSettings\AndroidFcmPlatformSettings;
use AvtoDev\FirebaseNotificationsChannel\PlatformSettings\WebpushFcmPlatformSettings;

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
    public function getWebpush(): WebpushFcmPlatformSettings
    {
        return $this->webpush;
    }

    /**
     * @param WebpushFcmPlatformSettings $webpush
     *
     * @return self
     */
    public function setWebpush(WebpushFcmPlatformSettings $webpush): self
    {
        $this->webpush = $webpush;

        return $this;
    }

    /**
     * @return AppleFcmPlatformSettings
     */
    public function getApns(): AppleFcmPlatformSettings
    {
        return $this->apns;
    }

    /**
     * @param AppleFcmPlatformSettings $apns
     *
     * @return self
     */
    public function setApns(AppleFcmPlatformSettings $apns): self
    {
        $this->apns = $apns;

        return $this;
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
     * @return self
     */
    public function setData(array $data): self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * The notification's title.
     *
     * @param string $title
     *
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * The notification's body text.
     *
     * @param string $body
     *
     * @return self
     */
    public function setBody($body): self
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
     *
     * @return self
     */
    public function setAndroid(AndroidFcmPlatformSettings $android): self
    {
        $this->android = $android;

        return $this;
    }

    /**
     * Build an array.
     *
     * @return array
     */
    public function toArray(): array
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
