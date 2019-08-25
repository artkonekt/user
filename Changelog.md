# Changelog

## 1.2 Series

### 1.2.1
##### 2019-08-25

- Using at least v1.0.1 of the Laravel Migration Compatibility library that fixes an [important bug](https://github.com/artkonekt/user/issues/2).

### 1.2.0
##### 2019-08-19

- Using the [Laravel Migration Compatibility v1.0](https://konekt.dev/migration-compatibility/1.0/README) package to properly solve the Laravel 5.8 + bigInt problem.
- Support for `USER_ID_IS_BIGINT` env variable in migrations has been dropped

## 1.1 Series

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

## 1.0 Series

### 1.0.0
##### 2019-01-20

- Call it a ~~day~~ release!
- Improved interfaces (Contracts)
- Proper/working Avatar support

## 0.9 Series

### 0.9.0
##### 2017-12-11

- First release, on AS-IS basis
