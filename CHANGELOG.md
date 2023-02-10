# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog][keepachangelog] and this project adheres to [Semantic Versioning][semver].

## Unreleased

### Changed

- Minimal require PHP version now is `8.0`
- Minimal Laravel version now is `9.0`
- Version of `composer` in docker container updated up to `2.5.3`

## v2.5.0

### Removed

- Dependency `tarampampam/wrappers-php` because this package was deprecated and removed

### Changed

- Minimal require PHP version now is `7.3`

## v2.4.0

### Added

- Support PHP `8.x`

### Changed

- Composer `2.x` is supported now

## v2.3.0

### Changed

- Laravel `8.x` is supported
- Minimal Laravel version now is `6.0` (Laravel `5.5` LTS got last security update August 30th, 2020)
- Guzzle `7.x` (`guzzlehttp/guzzle`) is supported
- Dependency `tarampampam/wrappers-php` version `~2.0` is supported

## v2.2.0

### Changed

- Maximal `illuminate/*` packages version now is `7.*`
- CI completely moved from "Travis CI" to "Github Actions" _(travis builds disabled)_
- Minimal required PHP version now is `7.2`
- Updated PHPDoc annotations
- Minimal `phpunit/phpunit` version now is `~7.2` (reason - class `PHPUnit\Framework\MockObject\MockObject`)
- Class `AvtoDev\FirebaseNotificationsChannel\Exceptions\CouldNotSendNotification` finalized
- Method `AvtoDev\FirebaseNotificationsChannel\FcmChannel::send` now returns `void`
- Methods in `AvtoDev\FirebaseNotificationsChannel\PlatformSettings\*::set*` now returns `void`

### Added

- PHP 7.4 is supported now

### Fixed

- Some documentation errors

## v2.1.0

### Changed

- Maximal `illuminate/*` packages version now is `6.*`

### Added

- GitHub actions for a tests running

## v2.0.0

### Added

- Docker-based environment for development
- Project `Makefile`

### Changed

- Minimal `PHP` version now is `^7.1.3`
- Maximal `Laravel` version now is `5.8.x`
- Composer scripts
- `\AvtoDev\FirebaseNotificationsChannel\FcmServiceProvider` &rarr; `\AvtoDev\FirebaseNotificationsChannel\ServiceProvider`

## v1.1.1

### Fixed

- Payload for apple device must contain an `aps` key [#7]

[#7]:https://github.com/avto-dev/firebase-notifications-laravel/issues/7

## v1.1.0

### Added

- Enable support of `mutable-content` for iOS 10+ devices

### Fixed

- Passthrough notifible to message

## v1.0.1

### Fixed

- Fixed config structure

## v1.0.0

### Added

- Basic code

[keepachangelog]:https://keepachangelog.com/en/1.0.0/
[semver]:https://semver.org/spec/v2.0.0.html
