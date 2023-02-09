<p align="center">
  <img src="https://laravel.com/assets/img/components/logo-laravel.svg" alt="Laravel" width="240" />
</p>

> Here's the latest documentation on Laravel Notifications System: <https://laravel.com/docs/master/notifications>

# Firebase notifications channel for Laravel applications

[![Version][badge_packagist_version]][link_packagist]
[![PHP Version][badge_php_version]][link_packagist]
[![Build Status][badge_build_status]][link_build_status]
[![Coverage][badge_coverage]][link_coverage]
[![Downloads count][badge_downloads_count]][link_packagist]
[![License][badge_license]][link_license]

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
$ composer require avto-dev/firebase-notifications-laravel "^2.0"
```

> Installed `composer` is required ([how to install composer][getcomposer]).

> You need to fix the major version of package.

Laravel 5.5 and above uses Package Auto-Discovery, so doesn't require you to manually register the service-provider. Otherwise you must add the service provider to the `providers` array in `./config/app.php`:

```php
<?php

return [

    // ...

    'providers' => [
        // ...
        AvtoDev\FirebaseNotificationsChannel\ServiceProvider::class,
    ],

];
```

### Setting up the Firebase service

You need to set up firebase channel in config file `./config/services.php`.

**To generate a private key file for your service account:**

1. In the Firebase console, open **Settings > [Service Accounts][firebase_service_account]**.
1. Click **Generate New Private Key**, then confirm by clicking **Generate Key**.
1. Securely store the JSON file containing the key. You'll need this JSON file to complete the next step.

Next select the "driver" `file` or `config` contains credintails for [Firebase service account][firebase_service_account] in `./config/services.php`:

```php
<?php

return [

    // ...

    /*
    |--------------------------------------------------------------------------
    | Firebase Settings section
    |--------------------------------------------------------------------------
    |
    | Here you may specify some configs for FCM.
    |
    */

    'fcm' => [

        /*
         |----------------------------------------------------------------------
         | Firebase service driver
         |----------------------------------------------------------------------
         |
         | Value `file` or `config`:
         |   - Select `file` option to make service read json file
         |   - Select `config` option to set up all section in config file
         |
         */

        'driver' => env('FCM_DRIVER', 'config'),

        /*
         |---------------------------------------------------------------------
         | FCM Drivers
         |---------------------------------------------------------------------
         |
         | Here are each of the firebase.
         |
         */

        'drivers' => [

            'file' => [
                'path' => env('FCM_FILE_PATH', base_path('storage/fcm.json')),
            ],

            'config' => [

                 /*
                 |------------------------------------------------------------
                 | Credentials
                 |------------------------------------------------------------
                 |
                 | Content of `firebase.json` file in config. Using if
                 | `fcm.driver` is `config`. All fields required!
                 |
                 */

                'credentials'=>[
                     'private_key_id'              => env('FCM_CREDENTIALS_PRIVATE_KEY_ID', 'da80b3bbceaa554442ad67e6be361a66'),
                     'private_key'                 => env('FCM_CREDENTIALS_PRIVATE_KEY', '-----BEGIN PRIVATE KEY-----\n...\n-----END PRIVATE KEY-----\n'),
                     'client_email'                => env('FCM_CREDENTIALS_CLIENT_EMAIL', 'firebase-adminsdk-mwax6@test.iam.gserviceaccount.com'),
                     'client_id'                   => env('FCM_CREDENTIALS_CLIENT_ID', '22021520333507180281'),
                     'auth_uri'                    => env('FCM_CREDENTIALS_AUTH_URI', 'https://accounts.google.com/o/oauth2/auth'),
                     'token_uri'                   => env('FCM_CREDENTIALS_TOKEN_URI', 'https://oauth2.googleapis.com/token'),
                     'auth_provider_x509_cert_url' => env('FCM_CREDENTIALS_AUTH_PROVIDER_CERT', 'https://www.googleapis.com/oauth2/v1/certs'),
                     'client_x509_cert_url'        => env('FCM_CREDENTIALS_CLIENT_CERT', 'https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-mwax6%40test.iam.gserviceaccount.com'),
                ],
            ],
        ],
    ],

];
```

## Usage

Now you can use the channel in your `via()` method inside the notification as well as send a push notification:

```php
<?php

use Illuminate\Notifications\Notification;
use AvtoDev\FirebaseNotificationsChannel\FcmChannel;
use AvtoDev\FirebaseNotificationsChannel\FcmMessage;

class AccountApproved extends Notification
{
    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    public function toFcm($notifiable, $notification)
    {
        return (new FcmMessage)
            ->setTitle('Approved!')
            ->setBody('Your account was approved!');
    }
}
```

```php
<?php

use Illuminate\Notifications\Notifiable;
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
    public function routeNotificationForFcm(): FcmNotificationReceiverInterface
    {
        return new FcmDeviceReceiver('firebase_token');
    }
}
```

### Available Message methods

This pakage supports all fields from [HTTP v1 FCM API][http_v1_fcm_api]. Message class contains setters for all the fields:

Field     | Type
:-------: | ----
`data`    | array
`title`   | string
`body`    | string
`android` | [AndroidFcmPlatformSettings][android_fcm_platform_settings]
`webpush` | [WebpushFcmPlatformSettings][webpush_fcm_platform_settings]
`apns`    | [AppleFcmPlatformSettings][apns_fcm_platform_settings]

[PlatformSettings][platform_settings] classes contain platform secific setters

## Testing

For package testing we use `phpunit` framework. Just write into your terminal _(installed `docker-ce` is required)_:

``` bash
$ git clone git@github.com:avto-dev/firebase-notifications-laravel.git ./firebase-notifications-laravel && cd $_
$ make install
$ make test
```

## Changes log

[![Release date][badge_release_date]][link_releases]
[![Commits since latest release][badge_commits_since_release]][link_commits]

Changes log can be [found here][link_changes_log].

## Support

[![Issues][badge_issues]][link_issues]
[![Issues][badge_pulls]][link_pulls]

If you will find any package errors, please, [make an issue][link_create_issue] in current repository.

## Security

If you discover any security related issues, please email `jetexe2@gmail.com` instead of using the issue tracker.

## Credits

- [jetexe](https://github.com/jetexe)
- [All Contributors](../../contributors)

## License

This is open-sourced software licensed under the [MIT License][link_license].

[badge_packagist_version]:https://img.shields.io/packagist/v/avto-dev/firebase-notifications-laravel.svg?maxAge=180
[badge_php_version]:https://img.shields.io/packagist/php-v/avto-dev/firebase-notifications-laravel.svg?longCache=true
[badge_build_status]:https://img.shields.io/github/actions/workflow/status/avto-dev/firebase-notifications-laravel/tests.yml
[badge_coverage]:https://img.shields.io/codecov/c/github/avto-dev/firebase-notifications-laravel/master.svg?maxAge=60
[badge_downloads_count]:https://img.shields.io/packagist/dt/avto-dev/firebase-notifications-laravel.svg?maxAge=180
[badge_license]:https://img.shields.io/packagist/l/avto-dev/firebase-notifications-laravel.svg?longCache=true
[badge_release_date]:https://img.shields.io/github/release-date/avto-dev/firebase-notifications-laravel.svg?style=flat-square&maxAge=180
[badge_commits_since_release]:https://img.shields.io/github/commits-since/avto-dev/firebase-notifications-laravel/latest.svg?style=flat-square&maxAge=180
[badge_issues]:https://img.shields.io/github/issues/avto-dev/firebase-notifications-laravel.svg?style=flat-square&maxAge=180
[badge_pulls]:https://img.shields.io/github/issues-pr/avto-dev/firebase-notifications-laravel.svg?style=flat-square&maxAge=180

[link_releases]:https://github.com/avto-dev/firebase-notifications-laravel/releases
[link_packagist]:https://packagist.org/packages/avto-dev/firebase-notifications-laravel
[link_build_status]:https://github.com/avto-dev/firebase-notifications-laravel/actions
[link_coverage]:https://codecov.io/gh/avto-dev/firebase-notifications-laravel/
[link_changes_log]:https://github.com/avto-dev/firebase-notifications-laravel/blob/master/CHANGELOG.md
[link_issues]:https://github.com/avto-dev/firebase-notifications-laravel/issues
[link_create_issue]:https://github.com/avto-dev/firebase-notifications-laravel/issues/new/choose
[link_commits]:https://github.com/avto-dev/firebase-notifications-laravel/commits
[link_pulls]:https://github.com/avto-dev/firebase-notifications-laravel/pulls
[link_license]:https://github.com/avto-dev/firebase-notifications-laravel/blob/master/LICENSE
[getcomposer]:https://getcomposer.org/download/

[firebase_home]:https://firebase.google.com/
[firebase_service_account]:https://console.firebase.google.com/project/_/settings/serviceaccounts/adminsdk
[http_v1_fcm_api]:https://firebase.google.com/docs/reference/fcm/rest/v1/projects.messages#resource-message

[android_fcm_platform_settings]:./src/PlatformSettings/AndroidFcmPlatformSettings.php
[webpush_fcm_platform_settings]:./src/PlatformSettings/WebpushFcmPlatformSettings.php
[apns_fcm_platform_settings]:./src/PlatformSettings/AppleFcmPlatformSettings.php
[platform_settings]:./src/PlatformSettings
