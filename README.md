# Konekt User

[![Tests](https://img.shields.io/github/actions/workflow/status/artkonekt/user/tests.yml?branch=2.x&style=flat-square)](https://github.com/artkonekt/user/actions?query=workflow%3Atests)
[![Packagist Stable Version](https://img.shields.io/packagist/v/konekt/user.svg?style=flat-square&label=stable)](https://packagist.org/packages/konekt/user)
[![StyleCI](https://styleci.io/repos/74651266/shield?branch=master)](https://styleci.io/repos/74651266)
[![Packagist downloads](https://img.shields.io/packagist/dt/konekt/user.svg?style=flat-square)](https://packagist.org/packages/konekt/user)
[![MIT Software License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat-square)](LICENSE.md)

Konekt User is a [Concord module](https://konekt.dev/concord/1.x/modules) that extends
Laravel's built-in user/auth functionality with profiles, addresses, organizations.

Internally relies on the [Konekt Address](https://github.com/artkonekt/address) module.

## Important Note On Laravel Auth Support

If the "final" user class is NOT going to be `App\Models\User` or (`App\User`) then don't forget to modify model class
this to your app's `config/auth.php` file:

```php
    //...
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            // 'model' => App\Models\User::class <- change this to:
            'model' => Konekt\User\Models\User::class,
        ],
    //...
```

## Laravel Compatibility

| Laravel | User Module |
|:--------|:------------|
| 5.4     | 0.9 - 1.2   |
| 5.5     | 0.9 - 1.4   |
| 5.6     | 0.9 - 1.4   |
| 5.7     | 0.9 - 1.4   |
| 5.8     | 1.0 - 1.4   |
| 6.x     | 1.3 - 2.3   |
| 7.x     | 1.4 - 2.3   |
| 8.x     | 1.5 - 2.5   |
| 9.x     | 2.1 - 2.8   |
| 10.x    | 2.7+        |
| 11.x    | 3.0+        |
| 12.x    | 3.1+        |

## PHP Compatibility

| PHP | User Module |
|:----|:------------|
| 7.0 | 0.9         |
| 7.1 | 0.9 - 1.3   |
| 7.2 | 0.9 - 1.4   |
| 7.3 | 1.1 - 1.5   |
| 7.4 | 1.4 - 1.5   |
| 8.0 | 2.1 - 2.8   |
| 8.1 | 2.4+        |
| 8.2 | 2.6+        |
| 8.3 | 2.8+        |
| 8.4 | 3.1+        |
