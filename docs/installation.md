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

!> **Laravel 5.4:** Register The Service Provider
> Edit `config/app.php` and add this line to the `providers` array
> (below 'Package Service Providers', always above 'Application Service Providers'):
>
> `Konekt\User\Providers\ModuleServiceProvider::class`

Test if all worked well by invoking the command:

```bash
php artisan concord:modules
```

Now you should see this:

```
+----+--------------------+--------+---------+-------------+-----------------+
| #  | Name               | Kind   | Version | Id          | Namespace       |
+----+--------------------+--------+---------+-------------+-----------------+
| 1. | Konekt User Module | Module | 1.1.0  | konekt.user | Konekt\User     |
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

#### Background

!> As of [Laravel 5.8](https://github.com/laravel/framework/pull/26472), migration stubs use the `bigIncrements` method on ID columns by default. Previously, ID columns were created using the increments method.

Foreign key columns must be of the same type. Therefore, a column created using the increments
method can not reference a column created using the bigIncrements method.

This small change is a big [source of problems](https://laraveldaily.com/be-careful-laravel-5-8-added-bigincrements-as-defaults/)
for packages that define references to the default Laravel user table.

This package contains the `Profile` model having the `profile` table beneath.
The profile belongs to a user via the `user_id` key. In order to keep the above mentioned
compatibility, the `user_id` field must be the same type (int or bigint) as the user table's `id`
field.

Unfortunately detecting if Laravel version is 5.8+ is not enough to find out whether `user.id` is
bigInt or int, since the host application could use bigInt even before Laravel 5.8 and can still use
plain int even after 5.8.

Best solution would be to detect the actual field type and act accordingly.
The problem with that solution is that it
[prevents from altering tables](https://laravel.com/docs/5.8/migrations#modifying-columns) with enum
fields, breaking the migrations in this package, especially with MySQL:

```
Unknown database type enum requested, Doctrine\DBAL\Platforms\MySQL57Platform may not support it.
```

In case you created your project with Laravel 5.8, then the user table is likely already a bigInt.

#### Solution

You can explicitly define whether to use bigInt for referring to the `user.id` field by setting the
value of `USER_ID_IS_BIGINT` to `true` or `false` in your `.env` file.

If there's no explicit value defined for `USER_ID_IS_BIGINT` then it'll be true in Laravel 5.8+ and
false for any earlier version.

This can solve migration problems like:

```
Migrating: 2016_12_18_121118_create_profiles_table

   Illuminate\Database\QueryException: SQLSTATE[HY000]: General error: 1005 Can't create table
   `vanilo`.`#sql-9a5_a6` (errno: 150 "Foreign key constraint is incorrectly formed")
   (SQL:
    alter table `profiles`
    add constraint `profiles_user_id_foreign`
    foreign key (`user_id`) references `users` (`id`)
   )
```

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
