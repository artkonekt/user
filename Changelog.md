# Changelog

## 3.x Series

## 3.0.0
##### 2024-04-25

- BC: Changed the `UserType` interface so that it now extends the `EnumInterface`
- Dropped Laravel 9 support
- Dropped PHP 8.0 support
- Added Laravel 11 support
- Changed minimum version requirements to:
  - Enum v4.1
  - Address v3.0
  - Doctrine DBAL v3.5.1/v4.x
- Got rid of the legacy Laravel factories in tests

---

## 2.x Series

## 2.8.0
##### 2023-12-17

- Added PHP 8.3 support

## 2.7.0
##### 2023-02-17

- Added Laravel 10 support

## 2.6.0
##### 2022-11-24

- Added PHP 8.2 support
- Dropped Laravel 8 support
- Changed minimum Laravel version to 9.2
- Allowing Doctrine DBAL v3

## 2.5.0
##### 2022-09-14

- Added method and property annotations to models and enums

## 2.4.0
##### 2022-03-10

- Added Enum v4 support
- Added PHP 8.1 support
- Dropped PHP 7.3 & 7.4 support
- Dropped Laravel 6 & 7 support
- Changed minimum Laravel version to 8.22.1, to enforce the [CVE-2021-21263](https://blog.laravel.com/security-laravel-62011-7302-8221-released) security patch

### 2.3.0
##### 2020-12-21

- Added the `pending()` scope to the Invitation model

### 2.2.0
##### 2020-12-19

- Added the Invitation feature
- Fixed user -> profile -> person relationships
- Changed CI from Travis to Github Actions
- Improved the Documentation

### 2.1.0
##### 2020-12-07

- Added PHP 8 support

### 2.0.0
##### 2020-10-11

- BC: Enums have been upgraded to v3
- Dropped Laravel 5 support

---

## 1.x Series

### 1.5.0
##### 2020-09-13

- Added Laravel 8 support
- Dropped PHP 7.2 support

### 1.4.0
##### 2020-03-14

- Added Laravel 7 support
- Dropped PHP 7.1 support
- Minimum required Concord version is 1.5+

### 1.3.0
##### 2019-11-23

- Added Laravel 6 support
- Removed Laravel 5.4 support
- Minimum required Concord version is 1.4+

### 1.2.1
##### 2019-08-25

- Using at least v1.0.1 of the Laravel Migration Compatibility library that fixes an [important bug](https://github.com/artkonekt/user/issues/2).

### 1.2.0
##### 2019-08-19

- Using the [Laravel Migration Compatibility v1.0](https://konekt.dev/migration-compatibility/1.0/README) package to properly solve the Laravel 5.8 + bigInt problem.
- Support for `USER_ID_IS_BIGINT` env variable in migrations has been dropped

### 1.1.1
##### 2019-07-14

- FIXED: broken migration for SQLite

### 1.1.0
##### 2019-06-30

- Proper Laravel 5.8 (bigInt user id) support
- PHP 7.3 support
- User type `api` has been added to the stock user type enum
- Documentation has been added - https://konekt.dev/user/1.1
- FIXED: broken migrations
- CI runs tests with mysql and postgres as well

### 1.0.0
##### 2019-01-20

- Call it a ~~day~~ release!
- Improved interfaces (Contracts)
- Proper/working Avatar support

---

## 0.x Series

### 0.9.0
##### 2017-12-11

- First release, on AS-IS basis
