<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel\PlatformSettings;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
class AndroidFcmPlatformSettings implements Arrayable
{
    /**
     * High priority.
     */
    public const PRIORITY_HIGH   = 'HIGH';

    /**
     * Normal priority.
     */
    public const PRIORITY_NORMAL = 'NORMAL';

    /**
     * An identifier of a group of messages that can be collapsed,
     * so that only the last message gets sent when delivery can be resumed.
     * A maximum of 4 different collapse keys is allowed at any given time.
     *
     * @var string
     */
    protected $collapse_key;

    /**
     * Message priority. Can take "normal" and "high" values.
     *
     * @var string
     */
    protected $priority;

    /**
     * A duration in seconds with up to nine fractional digits, terminated by 's'. Example: "3.5s".
     *
     * @var string
     */
    protected $ttl;

    /**
     * Package name of the application where the registration token must match in order to receive the message.
     *
     * @var string
     */
    protected $restricted_package_name;

    /**
     * Arbitrary key/value payload. If present, it will override google.firebase.fcm.v1.Message.data.
     * An object containing a list of "key": value pairs.
     *
     * @var array<string, mixed>
     */
    protected $data;

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
     * The notification's icon.
     * Sets the notification icon to myicon for drawable resource myicon.
     * If you don't send this key in the request, FCM displays the launcher icon specified in your app manifest.
     *
     * @var string
     */
    protected $icon;

    /**
     * The notification's icon color, expressed in #rrggbb format.
     *
     * @var string
     */
    protected $color;

    /**
     * The sound to play when the device receives the notification.
     * Supports "default" or the filename of a sound resource bundled in the app.
     * Sound files must reside in /res/raw/.
     *
     * @var string
     */
    protected $sound;

    /**
     * Identifier used to replace existing notifications in the notification drawer.
     * If not specified, each request creates a new notification.
     * If specified and a notification with the same tag is already being shown,
     * the new notification replaces the existing one in the notification drawer.
     *
     * @var string
     */
    protected $tag;

    /**
     * The action associated with a user click on the notification.
     * If specified, an activity with a matching intent filter is launched when a user clicks on the notification.
     *
     * @var string
     */
    protected $click_action;

    /**
     * The key to the body string in the app's string resources to use to localize the body text to the user's current
     * localization.
     *
     * @var string
     */
    protected $body_loc_key;

    /**
     * Variable string values to be used in place of the format specifiers in body_loc_key to use to localize the body
     * text to the user's current localization.
     *
     * @var array<string>
     */
    protected $body_loc_args;

    /**
     * The key to the title string in the app's string resources to use to localize the title text to the user's
     * current localization.
     *
     * @var string
     */
    protected $title_loc_key;

    /**
     * Variable string values to be used in place of the format specifiers in title_loc_key to use to localize the
     * title text to the user's current localization.
     *
     * @var array<string>
     */
    protected $title_loc_args;

    /**
     * The notification's channel id (new in Android O). The app must create a channel with this channel ID before any
     * notification with this channel ID is received. If you don't send this channel ID in the request, or if the
     * channel ID provided has not yet been created by the app, FCM uses the channel ID specified in the app manifest.
     *
     * @var string
     */
    protected $channel_id;

    /**
     * An identifier of a group of messages that can be collapsed,
     * so that only the last message gets sent when delivery can be resumed.
     * A maximum of 4 different collapse keys is allowed at any given time.
     *
     * @param string $collapse_key
     */
    public function setCollapseKey(string $collapse_key): void
    {
        $this->collapse_key = $collapse_key;
    }

    /**
     * Message priority. Can take "normal" and "high" values.
     *
     * @param string $priority
     */
    public function setPriority(string $priority): void
    {
        $this->priority = $priority;
    }

    /**
     * A duration in seconds with up to nine fractional digits, terminated by 's'. Example: "3.5s".
     *
     * @param string $ttl
     */
    public function setTtl(string $ttl): void
    {
        $this->ttl = $ttl;
    }

    /**
     * Package name of the application where the registration token must match in order to receive the message.
     *
     * @param string $restricted_package_name
     */
    public function setRestrictedPackageName(string $restricted_package_name): void
    {
        $this->restricted_package_name = $restricted_package_name;
    }

    /**
     * Arbitrary key/value payload. If present, it will override google.firebase.fcm.v1.Message.data.
     * An object containing a list of "key": value pairs.
     *
     * @param array<string, mixed> $data
     */
    public function setData(array $data): void
    {
        $this->data = $data;
    }

    /**
     * The notification's title. If present, it will override google.firebase.fcm.v1.Notification.title.
     *
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * The notification's body text. If present, it will override google.firebase.fcm.v1.Notification.body.
     *
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * The notification's icon.
     * Sets the notification icon to myicon for drawable resource myicon.
     * If you don't send this key in the request, FCM displays the launcher icon specified in your app manifest.
     *
     * @param string $icon
     */
    public function setIcon(string $icon): void
    {
        $this->icon = $icon;
    }

    /**
     * The notification's icon color, expressed in #rrggbb format.
     *
     * @param string $color
     */
    public function setColor(string $color): void
    {
        $this->color = $color;
    }

    /**
     * The sound to play when the device receives the notification.
     * Supports "default" or the filename of a sound resource bundled in the app.
     * Sound files must reside in /res/raw/.
     *
     * @param string $sound
     */
    public function setSound(string $sound): void
    {
        $this->sound = $sound;
    }

    /**
     * Identifier used to replace existing notifications in the notification drawer.
     * If not specified, each request creates a new notification.
     * If specified and a notification with the same tag is already being shown,
     * the new notification replaces the existing one in the notification drawer.
     *
     * @param string $tag
     */
    public function setTag(string $tag): void
    {
        $this->tag = $tag;
    }

    /**
     * The action associated with a user click on the notification.
     * If specified, an activity with a matching intent filter is launched when a user clicks on the notification.
     *
     * @param string $click_action
     */
    public function setClickAction(string $click_action): void
    {
        $this->click_action = $click_action;
    }

    /**
     * The key to the body string in the app's string resources to use to localize the body text to the user's current
     * localization.
     *
     * @param string $body_loc_key
     */
    public function setBodyLocKey(string $body_loc_key): void
    {
        $this->body_loc_key = $body_loc_key;
    }

    /**
     * Variable string values to be used in place of the format specifiers in body_loc_key to use to localize the body
     * text to the user's current localization.
     *
     * @param array<string> $body_loc_args
     */
    public function setBodyLocArgs(array $body_loc_args): void
    {
        $this->body_loc_args = $body_loc_args;
    }

    /**
     * The key to the title string in the app's string resources to use to localize the title text to the user's
     * current localization.
     *
     * @param string $title_loc_key
     */
    public function setTitleLocKey(string $title_loc_key): void
    {
        $this->title_loc_key = $title_loc_key;
    }

    /**
     * Variable string values to be used in place of the format specifiers in title_loc_key to use to localize the
     * title text to the user's current localization.
     *
     * @param array<string> $title_loc_args
     */
    public function setTitleLocArgs(array $title_loc_args): void
    {
        $this->title_loc_args = $title_loc_args;
    }

    /**
     * The notification's channel id (new in Android O). The app must create a channel with this channel ID before any
     * notification with this channel ID is received. If you don't send this channel ID in the request, or if the
     * channel ID provided has not yet been created by the app, FCM uses the channel ID specified in the app manifest.
     *
     * @param string $channel_id
     */
    public function setChannelId(string $channel_id): void
    {
        $this->channel_id = $channel_id;
    }

    /**
     * Build an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'collapse_key'            => $this->collapse_key,
            'priority'                => $this->priority,
            'ttl'                     => $this->ttl,
            'restricted_package_name' => $this->restricted_package_name,
            'data'                    => $this->data,
            'notification'            => [
                'title'          => $this->title,
                'body'           => $this->body,
                'icon'           => $this->icon,
                'color'          => $this->color,
                'sound'          => $this->sound,
                'tag'            => $this->tag,
                'click_action'   => $this->click_action,
                'body_loc_key'   => $this->body_loc_key,
                'body_loc_args'  => $this->body_loc_args,
                'title_loc_key'  => $this->title_loc_key,
                'title_loc_args' => $this->title_loc_args,
                'channel_id'     => $this->channel_id,
            ],
        ];
    }
}
