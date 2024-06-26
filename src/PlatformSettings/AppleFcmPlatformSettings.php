<?php

declare(strict_types = 1);

namespace AvtoDev\FirebaseNotificationsChannel\PlatformSettings;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
class AppleFcmPlatformSettings implements Arrayable
{
    /**
     * HTTP request headers defined in Apple Push Notification Service.
     * Refer to APNs request headers for supported headers, e.g. "apns-priority": "10".
     *
     * @var array<string, mixed>
     */
    protected $headers;

    /**
     * Include this key when you want the system to modify the badge of your app icon.
     * If this key is not included in the dictionary, the badge is not changed. To remove the badge, set the value of
     * this key to 0.
     *
     * @var int
     */
    protected $badge;

    /**
     *  Include this key when you want the system to play a sound. The value of this key is the name of a sound file in
     *  your app’s main bundle or in the Library/Sounds folder of your app’s data container. If the sound file cannot
     *  be found, or if you specify default for the value, the system plays the default alert sound.
     *
     * @var string
     */
    protected $sound;

    /**
     * Include this key with a value of 1 to configure a background update notification. When this key is present, the
     * system wakes up your app in the background and delivers the notification to its app delegate.
     *
     * @var int
     */
    protected $content_available;

    /**
     * Provide this key with a string value that represents the notification’s type. This value corresponds to the
     * value in the identifier property of one of your app’s registered categories.
     *
     * @var string
     */
    protected $category;

    /**
     * Provide this key with a string value that represents the app-specific identifier for grouping notifications. If
     * you provide a Notification Content app extension, you can use this value to group your notifications together.
     *
     * @var string
     */
    protected $thread_id;

    /**
     * A short string describing the purpose of the notification. Apple Watch displays this string as part of the
     * notification interface. This string is displayed only briefly and should be crafted so that it can be understood
     * quickly. This key was added in iOS 8.2.
     *
     * @var string
     */
    protected $title;

    /**
     * The text of the alert message.
     *
     * @var string
     */
    protected $body;

    /**
     * The key to a title string in the Localizable.strings file for the current localization. The key string can be
     * formatted with %@ and %n$@ specifiers to take the variables specified in the title-loc-args array.
     *
     * This key was added in iOS 8.2.
     *
     * @var string
     */
    protected $title_loc_key;

    /**
     * Variable string values to appear in place of the format specifiers in title-loc-key.
     *
     * This key was added in iOS 8.2.
     *
     * @var array<string>
     */
    protected $title_loc_args;

    /**
     * If a string is specified, the system displays an alert that includes the Close and View buttons. The string is
     * used as a key to get a localized string in the current localization to use for the right button’s title instead
     * of “View”.
     *
     * @var string
     */
    protected $action_loc_key;

    /**
     * A key to an alert-message string in a Localizable.strings file for the current localization (which is set by the
     * user’s language preference). The key string can be formatted with %@ and %n$@ specifiers to take the variables
     * specified in the loc-args array.
     *
     * @var string
     */
    protected $loc_key;

    /**
     * Variable string values to appear in place of the format specifiers in loc-key.
     *
     * @var array<string>
     */
    protected $loc_args;

    /**
     * The filename of an image file in the app bundle, with or without the filename extension. The image is used as
     * the launch image when users tap the action button or move the action slider. If this property is not specified,
     * the system either uses the previous snapshot, uses the image identified by the UILaunchImageFile key in the
     * app’s Info.plist file, or falls back to Default.png.
     *
     * @var string
     */
    protected $launch_image;

    /**
     * Allow to modify payload on iOS 10+ devices.
     *
     * @see https://developer.apple.com/documentation/usernotifications/unnotificationserviceextension
     *
     * @var bool
     */
    protected $mutable_content;

    /**
     * HTTP request headers defined in Apple Push Notification Service.
     * Refer to APNs request headers for supported headers, e.g. "apns-priority": "10".
     *
     * @param array<string, mixed> $headers
     */
    public function setHeaders(array $headers): void
    {
        $this->headers = $headers;
    }

    /**
     * Include this key when you want the system to modify the badge of your app icon.
     * If this key is not included in the dictionary, the badge is not changed. To remove the badge, set the value of
     * this key to 0.
     *
     * @param int $badge
     */
    public function setBadge(int $badge): void
    {
        $this->badge = $badge;
    }

    /**
     * Include this key when you want the system to play a sound. The value of this key is the name of a sound file in
     *  your app’s main bundle or in the Library/Sounds folder of your app’s data container. If the sound file cannot
     *  be found, or if you specify default for the value, the system plays the default alert sound.
     *
     * @param string $sound
     */
    public function setSound(string $sound): void
    {
        $this->sound = $sound;
    }

    /**
     * Include this key with a value of 1 to configure a background update notification. When this key is present, the
     * system wakes up your app in the background and delivers the notification to its app delegate.
     *
     * @param int $content_available
     */
    public function setContentAvailable(int $content_available): void
    {
        $this->content_available = $content_available;
    }

    /**
     * Provide this key with a string value that represents the notification’s type. This value corresponds to the
     * value in the identifier property of one of your app’s registered categories.
     *
     * @param string $category
     */
    public function setCategory(string $category): void
    {
        $this->category = $category;
    }

    /**
     * Provide this key with a string value that represents the app-specific identifier for grouping notifications. If
     * you provide a Notification Content app extension, you can use this value to group your notifications together.
     *
     * @param string $thread_id
     */
    public function setThreadId(string $thread_id): void
    {
        $this->thread_id = $thread_id;
    }

    /**
     * A short string describing the purpose of the notification. Apple Watch displays this string as part of the
     * notification interface. This string is displayed only briefly and should be crafted so that it can be understood
     * quickly. This key was added in iOS 8.2.
     *
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * The text of the alert message.
     *
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * The key to a title string in the Localizable.strings file for the current localization. The key string can be
     * formatted with %@ and %n$@ specifiers to take the variables specified in the title-loc-args array.
     *
     * This key was added in iOS 8.2.
     *
     * @param string $title_loc_key
     */
    public function setTitleLocKey(string $title_loc_key): void
    {
        $this->title_loc_key = $title_loc_key;
    }

    /**
     * Variable string values to appear in place of the format specifiers in title-loc-key.
     *
     * This key was added in iOS 8.2.
     *
     * @param array<string> $title_loc_args
     */
    public function setTitleLocArgs(array $title_loc_args): void
    {
        $this->title_loc_args = $title_loc_args;
    }

    /**
     * If a string is specified, the system displays an alert that includes the Close and View buttons. The string is
     * used as a key to get a localized string in the current localization to use for the right button’s title instead
     * of “View”.
     *
     * @param string $action_loc_key
     */
    public function setActionLocKey(string $action_loc_key): void
    {
        $this->action_loc_key = $action_loc_key;
    }

    /**
     * A key to an alert-message string in a Localizable.strings file for the current localization (which is set by the
     * user’s language preference). The key string can be formatted with %@ and %n$@ specifiers to take the variables
     * specified in the loc-args array.
     *
     * @param string $loc_key
     */
    public function setLocKey(string $loc_key): void
    {
        $this->loc_key = $loc_key;
    }

    /**
     * Variable string values to appear in place of the format specifiers in loc-key.
     *
     * @param array<string> $loc_args
     */
    public function setLocArgs(array $loc_args): void
    {
        $this->loc_args = $loc_args;
    }

    /**
     * The filename of an image file in the app bundle, with or without the filename extension. The image is used as
     * the launch image when users tap the action button or move the action slider. If this property is not specified,
     * the system either uses the previous snapshot, uses the image identified by the UILaunchImageFile key in the
     * app’s Info.plist file, or falls back to Default.png.
     *
     * @param string $launch_image
     */
    public function setLaunchImage(string $launch_image): void
    {
        $this->launch_image = $launch_image;
    }

    public function setMutableContent(bool $mutable_content): void
    {
        $this->mutable_content = $mutable_content;
    }

    /**
     * Build an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'headers' => $this->headers,
            'payload' => [
                'aps' => [
                    'alert'             => [
                        'title'          => $this->title,
                        'body'           => $this->body,
                        'title-loc-key'  => $this->title_loc_key,
                        'title-loc-args' => $this->title_loc_args,
                        'action-loc-key' => $this->action_loc_key,
                        'loc-key'        => $this->loc_key,
                        'loc-args'       => $this->loc_args,
                        'launch-image'   => $this->launch_image,
                    ],
                    'badge'             => $this->badge,
                    'sound'             => $this->sound,
                    'content-available' => $this->content_available,
                    'category'          => $this->category,
                    'thread-id'         => $this->thread_id,
                    'mutable-content'   => (int) $this->mutable_content,
                ],
            ],
        ];
    }
}
