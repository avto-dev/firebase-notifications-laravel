# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog][keepachangelog] and this project adheres to [Semantic Versioning][semver].

## Unreleased

### Changed

- Maximal `illuminate/*` packages version now is `6.*`

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
