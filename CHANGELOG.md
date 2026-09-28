# Changelog

All notable changes to this package are documented in this file. Versions
follow [Semantic Versioning](https://semver.org). New entries are generated from
commit messages by [dry-ci](https://github.com/TallieuTallieu/dry-ci); past
entries may be edited by hand.

## 3.0.3 - 2026-09-18

### Breaking changes

- Require PHP ^8.4; projects on an older PHP version must upgrade PHP before updating ([sc-11478](https://app.shortcut.com/tallieu--tallieu/story/11478))

### Other changes

- Accept oak ^4.0 alongside ^3.0.2 ([sc-11478](https://app.shortcut.com/tallieu--tallieu/story/11478))

## 3.0.2 - 2026-05-06

### Other changes

- Accept dry ^3.0.0 and ^4.0.0, replacing the ^3.8.0-beta.14 constraint from 3.0.1

## 3.0.1 - 2026-01-21

### Breaking changes

- Require dry ^3.8.0-beta.14; projects on an older dry must upgrade dry before updating (relaxed again in 3.0.2)

### Other changes

- Add PHPDoc annotations to the `Api` facade for IDE support

## 3.0.0 - 2025-08-29

### Breaking changes

- Require oak ^3.0.2; oak 1.x and `dev-php8.2` are no longer accepted, so projects must upgrade to oak 3 before updating

### Other changes

- Remove the authors section from composer.json

## Earlier history

- **1.0.0** (2019-10-07): First release as `dietervyncke/dry-external-api`: versioned routes registered through the `Api` facade (`get`, `post`, `put`, `patch`, `delete`), controllers resolved from the oak container, a `Request` wrapper with `validate()`, and `ApiException` for JSON error responses
- **1.0.1** (2021-03-23): Package moved to T&T and renamed to `tallieutallieu/dry-external-api`; the oak dependency became `tallieutallieu/oak` instead of `reinvanoyen/oak`
- **1.0.2** (2025-02-11): Declare `Request::$parameters` to fix a PHP 8.2 dynamic property deprecation
- **1.0.3** (2025-02-11): Accept oak `dev-php8.2` for PHP 8.2 compatibility
- **1.0.4** (2025-03-11): Type `Request::$parameters` as `RequestDataWrapper`
- **2.0.0** (2025-03-11): Add a `Response` class with status and error code constants and helpers (`ok`, `created`, `badRequest`, `invalidData`, `unauthorized`, `forbidden`, `notFound`, `internalError`) plus `ValidationData`; a controller that returns a `Response` now sets the HTTP status code and returns `success`, `error_code` and `data` ([sc-7184](https://app.shortcut.com/tallieu--tallieu/story/7184))
- **2.0.1** (2025-05-15): Fix the router calling the controller method twice when it does not return a `Response`

See the git tags before 3.0.0 for the full history.
