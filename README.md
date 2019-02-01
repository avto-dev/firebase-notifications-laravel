
<p align="center">
  <img src="https://laravel.com/assets/img/components/logo-laravel.svg" alt="Laravel" width="240" />
</p>

Here's the latest documentation on Laravel Notifications System:

https://laravel.com/docs/master/notifications

# Google Firebase notification channel

[![Latest Version on Packagist][badge_packagist_version]][link_packagist_version]
[![Software License][badge_license]](LICENSE)
[![Build Status][badge_build_status]][link_build_status]
[![StyleCI][badge_style_ci]][link_style_ci]
[![SensioLabsInsight][badge_sensiolabs_insight]][link_sensiolabs_insigh]
[![Quality Score][badge_quality]][link_quality]
[![Code Coverage][badge_coverage]][link_coverage]
[![Total Downloads][badge_downloads]][link_downloads]

This package makes it easy to send notifications using [Firebase][firebase_home] with Laravel 5.

## Contents

- [Installation](#installation)
   - [Setting up the Firebase service](#setting-up-the-Firebase-service)
- [Usage](#usage)
   - [Available Message methods](#available-message-methods)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

```bash
composer require laravel-notification-channels/webpush
```

First you must install the service provider (skip for Laravel>=5.5):
```php
// config/app.php
'providers' => [
    ...
    AvtoDev\FirebaseNotificationsChannel\FcmServiceProvider::class,
],
```

### Setting up the Firebase service

You need to set up firebase channel in config file `config/services.conf`

**To generate a private key file for your service account:**

1.  In the Firebase console, open **Settings > [Service Accounts][firebase_service_account]**.

2.  Click **Generate New Private Key**, then confirm by clicking **Generate Key**.

3.  Securely store the JSON file containing the key. You'll need this JSON file to complete the next step.

Next select the "driver" `file` or `config` contains credintails for [Firebase service account][firebase_service_account]

`file` usage 
```php
// config/service.conf

/**
 * Firebas Settings section
 */
/**
 * Firebase service driver
 * Value `file` or `config`
 *    - select `file` option to make service read json file
 *    - select `config` option to set up all section in config file
 */
'fcm.driver'=>'file',

/**
 * Path to json file contains credintails
 * using if `fcm.driver` is `file`
 */
'fcm.file'=>'/path/to/firebase.json',
```

 `config` usage

```php
// config/service.conf

/**
 * Firebas Settings section
 */
'fcm'=>[
    /**
     * Firebase service driver
     * Value `file` or `config`
     *    - select `file` option to make service read json file
     *    - select `config` option to set up all section in config file
     */
    'driver'=>'config',

    /**
     * Content of `firebase.json` file in config
     * using if `fcm.driver` is `config`
     * All fields required
     */
    'credintails'=>[
         'type'=> 'service_account',
         'project_id'=> 'test',
         'private_key_id'=> 'da80b3bbceaa554442ad67e6be361a66',
         'private_key'=> '-----BEGIN PRIVATE KEY-----\nQXJlIHlvdSByZWFseSB0aGluayBhJ20gc28gc3R1cGlkIHRvIGdpd\nmUgeW91IHJlYWwgcHJpdmF0ZSBrZXk/Ck5PISBJdCdzIGp1c3QgY\nSBmaWN0aW9uIGFuZCB0aGlzIG1lc3NhZ2UgaXMgdG8gc2hvcnQ=\n-----END PRIVATE KEY-----\n',
         'client_email'=> 'firebase-adminsdk-mwax6@test.iam.gserviceaccount.com',
         'client_id'=> '22021520333507180281',
         'auth_uri'=> 'https://accounts.google.com/o/oauth2/auth',
         'token_uri'=> 'https://oauth2.googleapis.com/token',
         'auth_provider_x509_cert_url'=> 'https://www.googleapis.com/oauth2/v1/certs',
         'client_x509_cert_url'=> 'https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-mwax6%40test.iam.gserviceaccount.com'
    ]
```

## Usage

Now you can use the channel in your `via()` method inside the notification as well as send a push notification:

```php
use Illuminate\Notifications\Notification;
use AvtoDev\FirebaseNotificationsChannel\FcmMessage;
use AvtoDev\FirebaseNotificationsChannel\FcmChannel;

class AccountApproved extends Notification
{
    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    public function toFcm($notifiable, $notification)
    {
        return (new FcmMessage)
            ->title('Approved!')
            ->body('Your account was approved!');
    }
}
```

```php
use AvtoDev\FirebaseNotificationsChannel\Receivers\FcmDeviceReceiver;
use AvtoDev\FirebaseNotificationsChannel\Receivers\FcmNotificationReceiverInterface;

class SomeNotifible
{
    use Notifiable;

    /**
    * Reveiver of firebase notification.
    * 
    * @return FcmNotificationReceiverInterface
    */
    public function routeNotificationForFcm()
    {
        return new FcmDeviceReceiver($this->firebase_token);
    }
}
```

### Available Message methods

This pakage supports all fields from [HTTP v1 FCM API][http_v1_fcm_api]
Message class contains setters for all the fields

| Field | Type |
|--- | ---|
| `data` | array |
| `title` | string |
| `body` | string |
| `android` | [AndroidFcmPlatformSettings][android_fcm_platform_settings] |
| `webpush` | [WebpushFcmPlatformSettings][webpush_fcm_platform_settings] |
| `apns`    | [AppleFcmPlatformSettings][apns_fcm_platform_settings] |

[PlatformSettings][platform_settings] classes contain platform secific setters


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email jetexe2@gmail.com instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [jetexe](https://github.com/jetexe)
- [DmitriyRuppel](https://github.com/DmitriyRuppel)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.


[badge_packagist_version]:https://img.shields.io/packagist/v/laravel-notification-channels/:package_name.svg?style=flat-square
[badge_license]:https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[badge_build_status]:https://img.shields.io/travis/avto-dev/firebase-notifications-laravel/master.svg?style=flat-square
[badge_style_ci]:https://styleci.io/repos/166985299/shield
[badge_sensiolabs_insight]:https://insight.symfony.com/projects/d28e31ec-55ce-4306-88a3-84d5d14ad3db/mini.svg
[badge_quality]:https://scrutinizer-ci.com/g/avto-dev/firebase-notifications-laravel/badges/quality-score.png
[badge_coverage]:https://img.shields.io/codecov/c/github/avto-dev/firebase-notifications-laravel/master.svg?maxAge=60
[badge_downloads]:https://img.shields.io/packagist/dt/laravel-notification-channels/:package_name.svg?style=flat-square


[link_packagist_version]:https://packagist.org/packages/laravel-notification-channels/:package_name
[link_build_status]:https://travis-ci.org/avto-dev/firebase-notifications-laravel
[link_style_ci]:https://styleci.io/repos/166985299
[link_sensiolabs_insigh]:https://insight.sensiolabs.com/projects/30f81f3f-d20d-4cb4-8d1f-d88cbab612e0
[link_quality]:https://scrutinizer-ci.com/g/avto-dev/firebase-notifications-laravel
[link_coverage]:https://codecov.io/gh/avto-dev/firebase-notifications-laravel
[link_downloads]:https://packagist.org/packages/laravel-notification-channels/:package_name

[firebase_home]:https://firebase.google.com/
[firebase_service_account]:https://console.firebase.google.com/project/_/settings/serviceaccounts/adminsdk
[http_v1_fcm_api]:https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages#resource-message

[android_fcm_platform_settings]:src/PlatformSettings/AndroidFcmPlatformSettings.php
[webpush_fcm_platform_settings]:src/PlatformSettings/WebpushFcmPlatformSettings.php
[apns_fcm_platform_settings]:src/PlatformSettings/AppleFcmPlatformSettings.php
[platform_settings]:src/PlatformSettings
