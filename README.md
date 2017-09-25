# Konekt User

Konekt User is a [Concord module](https://artkonekt.github.io/concord/#/modules) that extends Laravel's built in user/auth functionality with profiles, addresses, organizations.

Internally relies on the [Konekt Address](https://github.com/artkonekt/address) module.

## Important Note On Laravel Auth Support

If the "final" user class is not going to be `App\User` then don't forget to modify model class this to your app's `config/auth.php` file:

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