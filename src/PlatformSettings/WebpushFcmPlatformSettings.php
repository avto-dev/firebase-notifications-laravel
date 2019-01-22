<?php

namespace AvtoDev\FirebaseCloudMessaging\PlatformSettings;

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
    public function setHeaders($headers)
    {
        $this->headers = $headers;
    }

    /**
     * Arbitrary key/value payload. If present, it will override google.firebase.fcm.v1.Message.data.
     *
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * The link to open when the user clicks on the notification. For all URL values, HTTPS is required.
     *
     * @param string $link
     */
    public function setLink($link)
    {
        $this->link = $link;
    }

    /**
     * The notification's title. If present, it will override google.firebase.fcm.v1.Notification.title.
     *
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * The notification's body text. If present, it will override google.firebase.fcm.v1.Notification.body.
     *
     * @param string $body
     */
    public function setBody($body)
    {
        $this->body = $body;
    }

    /**
     * The actions array of the notification as specified in the constructor's options parameter.
     *
     * @param array $value
     */
    public function setActions($value)
    {
        $this->actions = $value;
    }

    /**
     * The URL of the image used to represent the notification when there is not enough space to display the
     * notification itself.
     *
     * @var string
     */
    public function setBadge($value)
    {
        $this->badge = $value;
    }

    /**
     * The text direction of the notification as specified in the constructor's options parameter.
     *
     * @var string
     */
    public function setDir($value)
    {
        $this->dir = $value;
    }

    /**
     * The language code of the notification as specified in the constructor's options parameter.
     *
     * @var string
     */
    public function setLang($value)
    {
        $this->lang = $value;
    }

    /**
     * The ID of the notification (if any) as specified in the constructor's options parameter.
     *
     * @var string
     */
    public function setTag($value)
    {
        $this->tag = $value;
    }

    /**
     * The URL of the image used as an icon of the notification as specified in the constructor's options parameter.
     *
     * @var string
     */
    public function setIcon($value)
    {
        $this->icon = $value;
    }

    /**
     * The URL of an image to be displayed as part of the notification, as specified in the constructor's options
     * parameter.
     *
     * @var string
     */
    public function setImage($value)
    {
        $this->image = $value;
    }

    /**
     * Specifies whether the user should be notified after a new notification replaces an old one.
     *
     * @var bool
     */
    public function setRenotify($value)
    {
        $this->renotify = $value;
    }

    /**
     * A Boolean indicating that a notification should remain active until the user clicks or dismisses it, rather than
     * closing automatically.
     *
     * @var bool
     */
    public function setRequireInteraction($value)
    {
        $this->requireInteraction = $value;
    }

    /**
     * Specifies whether the notification should be silent — i.e., no sounds or vibrations should be issued, regardless
     * of the device settings.
     */
    public function setSilent($value)
    {
        $this->silent = $value;
    }

    /**
     * Specifies the time at which a notification is created or applicable (past, present, or future).
     *
     * @var int
     */
    public function setTimestamp($value)
    {
        $this->timestamp = $value;
    }

    /**
     * Specifies a vibration pattern for devices with vibration hardware to emit.
     *
     * @var bool
     */
    public function setVibrate($value)
    {
        $this->vibrate = $value;
    }

    /**
     * Build an array.
     *
     * @return array
     */
    public function toArray()
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
