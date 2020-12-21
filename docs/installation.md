# Installation

```bash
composer require konekt/user
touch config/concord.php
```

Edit `config/concord.php` and add this content to it:

```php
<?php

return [
    'modules' => [
        Konekt\User\Providers\ModuleServiceProvider::class
    ]
];
```

Test if all worked well by invoking the command:

```bash
php artisan concord:modules
```

Now you should see this:

```
+----+--------------------+--------+---------+-------------+-----------------+
| #  | Name               | Kind   | Version | Id          | Namespace       |
+----+--------------------+--------+---------+-------------+-----------------+
| 1. | Konekt User Module | Module | 2.3.0  | konekt.user | Konekt\User     |
+----+--------------------+--------+---------+-------------+-----------------+
```

> **TIP:** Try `php artisan concord:modules -a` to see ALL modules

## Migrations

Configure `.env`, along with a database.

Afterwards run the migrations:

```bash
php artisan migrate
```

The user module contains 2 migrations out of the box

### Laravel 5.8 and Bigint Compatibility

!> As of [Laravel 5.8](https://github.com/laravel/framework/pull/26472), migration stubs use the `bigIncrements` method on ID columns by default. Previously, ID columns were created using the increments method.

Foreign key columns must be of the same type. Therefore, a column created using the increments
method can not reference a column created using the bigIncrements method.

This package contains the `Profile` model having the `profile` table beneath.
The profile belongs to a user via the `user_id` key. In order to keep the above mentioned
compatibility, the `user_id` field must be the same type (int or bigint) as the user table's `id`
field.

!> The `USER_ID_IS_BIGINT` env support introduced in [version 1.1](https://konekt.dev/user/1.1/installation#laravel-58-and-bigint-compatibility) has been removed as of v1.2 due to [issues](https://github.com/artkonekt/user/issues/1) with it.

To solve this problem, the profiles table migration uses the
[Laravel Migration Compatibility](https://github.com/artkonekt/laravel-migration-compatibility)
package. It attempts to automatically detect the actual type from the database.

In case autodetection fails on your system, you can explicitly tell the exact type via configuration:

```php
// for bigint
config(['migration.compatibility.map.comments.id' => 'bigint unsigned']);

// for "old" int:
config(['migration.compatibility.map.comments.id' => 'int unsigned']);
```

For more options refer to the
[Configuration](https://konekt.dev/migration-compatibility/1.0/configuration) section.

## Laravel Auth Support

First, run `php artisan make:auth` in your application.

**If** the "final" user class is not going to be `App\User` then don't forget to modify model class this
to your app's `config/auth.php` file:

```php
    //...
    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            // 'model' => App\User::class <- change this to:
            'model' => Konekt\User\Models\User::class,
        ],
    //...
```
**OR:**
Another approach is to keep `App\User` but modify the class to extend this user model:

```php
namespace App;

// No need to use Laravel default traits and properties as
// they're already present in the base class

class User extends \Konekt\User\Models\User
{
}
```

And add this to you `AppServiceProviders`'s boot method:

```php
   $this->app->concord->registerModel(\Konekt\User\Contracts\User::class, \App\User::class);
```

---

**Next**: [Active/Inactive Status &raquo;](active-inactive.md)
