<?php

namespace AvtoDev\FirebaseNotificationsChannel\PlatformSettings;

use Illuminate\Contracts\Support\Arrayable;

/**
 * Webpush protocol options.
 */
class WebpushFcmPlatformSettings implements Arrayable
{
    /**
     * HTTP headers defined in webpush protocol. Refer to Webpush protocol for supported headers, e.g. "TTL": "15".
     *
     * @var array
     */
    protected $headers;

    /**
     * Arbitrary key/value payload. If present, it will override google.firebase.fcm.v1.Message.data.
     *
     * @var array
     */
    protected $data;

    /**
     * The link to open when the user clicks on the notification. For all URL values, HTTPS is required.
     *
     * @var string
     */
    protected $link;

    /**
     * The notification's title. If present, it will override google.firebase.fcm.v1.Notification.title.
     *
     * @var string
     */
    protected $title;

    /**
     * The notification's body text. If present, it will override google.firebase.fcm.v1.Notification.body.
     *
     * @var string
     */
    protected $body;

    /**
     * The actions array of the notification as specified in the constructor's options parameter.
     *
     * @var array
     */
    protected $actions;

    /**
     * The URL of the image used to represent the notification when there is not enough space to display the
     * notification itself.
     *
     * @var string
     */
    protected $badge;

    /**
     * The text direction of the notification as specified in the constructor's options parameter.
     *
     * @var string
     */
    protected $dir;

    /**
     * The language code of the notification as specified in the constructor's options parameter.
     *
     * @var string
     */
    protected $lang;

    /**
     * The ID of the notification (if any) as specified in the constructor's options parameter.
     *
     * @var string
     */
    protected $tag;

    /**
     * The URL of the image used as an icon of the notification as specified in the constructor's options parameter.
     *
     * @var string
     */
    protected $icon;

    /**
     * The URL of an image to be displayed as part of the notification, as specified in the constructor's options
     * parameter.
     *
     * @var string
     */
    protected $image;

    /**
     * Specifies whether the user should be notified after a new notification replaces an old one.
     *
     * @var bool
     */
    protected $renotify;

    /**
     * A Boolean indicating that a notification should remain active until the user clicks or dismisses it, rather than
     * closing automatically.
     *
     * @var bool
     */
    protected $requireInteraction;

    /**
     * Specifies whether the notification should be silent — i.e., no sounds or vibrations should be issued, regardless
     * of the device settings.
     *
     * @var bool
     */
    protected $silent;

    /**
     * Specifies the time at which a notification is created or applicable (past, present, or future).
     *
     * @var int
     */
    protected $timestamp;

    /**
     * Specifies a vibration pattern for devices with vibration hardware to emit.
     *
     * @var bool
     */
    protected $vibrate;

    /**
     * HTTP headers defined in webpush protocol. Refer to Webpush protocol for supported headers, e.g. "TTL": "15".
     *
     * @param array $headers
     */
    public function setHeaders(array $headers)
    {
        $this->headers = $headers;
    }

    /**
     * Arbitrary key/value payload. If present, it will override google.firebase.fcm.v1.Message.data.
     *
     * @param array $data
     */
    public function setData(array $data)
    {
        $this->data = $data;
    }

    /**
     * The link to open when the user clicks on the notification. For all URL values, HTTPS is required.
     *
     * @param string $link
     */
    public function setLink(string $link)
    {
        $this->link = $link;
    }

    /**
     * The notification's title. If present, it will override google.firebase.fcm.v1.Notification.title.
     *
     * @param string $title
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    /**
     * The notification's body text. If present, it will override google.firebase.fcm.v1.Notification.body.
     *
     * @param string $body
     */
    public function setBody(string $body)
    {
        $this->body = $body;
    }

    /**
     * The actions array of the notification as specified in the constructor's options parameter.
     *
     * @param array $value
     */
    public function setActions(array $value)
    {
        $this->actions = $value;
    }

    /**
     * The URL of the image used to represent the notification when there is not enough space to display the
     * notification itself.
     *
     * @var string
     *
     * @param mixed $value
     */
    public function setBadge(string $value)
    {
        $this->badge = $value;
    }

    /**
     * The text direction of the notification as specified in the constructor's options parameter.
     *
     * @var string
     *
     * @param mixed $value
     */
    public function setDir(string $value)
    {
        $this->dir = $value;
    }

    /**
     * The language code of the notification as specified in the constructor's options parameter.
     *
     * @var string
     *
     * @param mixed $value
     */
    public function setLang(string $value)
    {
        $this->lang = $value;
    }

    /**
     * The ID of the notification (if any) as specified in the constructor's options parameter.
     *
     * @var string
     *
     * @param mixed $value
     */
    public function setTag(string $value)
    {
        $this->tag = $value;
    }

    /**
     * The URL of the image used as an icon of the notification as specified in the constructor's options parameter.
     *
     * @var string
     *
     * @param mixed $value
     */
    public function setIcon(string $value)
    {
        $this->icon = $value;
    }

    /**
     * The URL of an image to be displayed as part of the notification, as specified in the constructor's options
     * parameter.
     *
     * @var string
     *
     * @param mixed $value
     */
    public function setImage(string $value)
    {
        $this->image = $value;
    }

    /**
     * Specifies whether the user should be notified after a new notification replaces an old one.
     *
     * @var bool
     *
     * @param mixed $value
     */
    public function setRenotify(bool $value)
    {
        $this->renotify = $value;
    }

    /**
     * A Boolean indicating that a notification should remain active until the user clicks or dismisses it, rather than
     * closing automatically.
     *
     * @var bool
     *
     * @param mixed $value
     */
    public function setRequireInteraction(bool $value)
    {
        $this->requireInteraction = $value;
    }

    /**
     * Specifies whether the notification should be silent — i.e., no sounds or vibrations should be issued, regardless
     * of the device settings.
     *
     * @param bool $value
     */
    public function setSilent(bool $value)
    {
        $this->silent = $value;
    }

    /**
     * Specifies the time at which a notification is created or applicable (past, present, or future).
     *
     * @var int
     *
     * @param mixed $value
     */
    public function setTimestamp(int $value)
    {
        $this->timestamp = $value;
    }

    /**
     * Specifies a vibration pattern for devices with vibration hardware to emit.
     *
     * @var bool
     *
     * @param mixed $value
     */
    public function setVibrate(bool $value)
    {
        $this->vibrate = $value;
    }

    /**
     * Build an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'headers'      => $this->headers,
            'data'         => $this->data,
            'notification' => [
                'actions'            => $this->actions,
                'badge'              => $this->badge,
                'body'               => $this->body,
                'data'               => $this->data,
                'dir'                => $this->dir,
                'lang'               => $this->lang,
                'tag'                => $this->tag,
                'icon'               => $this->icon,
                'image'              => $this->image,
                'renotify'           => $this->renotify,
                'requireInteraction' => $this->requireInteraction,
                'silent'             => $this->silent,
                'timestamp'          => $this->timestamp,
                'title'              => $this->title,
                'vibrate'            => $this->vibrate,
            ],
            'fcm_options'  => [
                'link' => $this->link,
            ],
        ];
    }
}
