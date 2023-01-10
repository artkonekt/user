# Customization

## Custom User Types

The user type is an [Enum](https://konekt.dev/enum) that has been registered with
[Concord](https://konekt.dev/concord/1.3/enums), therefore it can be fully customized.

### Add More Values To The Default User Types

This package ships with a default `UserType` Enum that can be either `client` (default), `admin` or
`api`. It's possible to use those and add one or more values.

**1. Create an extended enum in your app:**

```php
// app/UserType.php:
namespace App;

class UserType extends \Konekt\User\Models\UserType
{
    // Adding a new value:
    const CONTRACTOR = 'contractor';

    // Changing the default value:
    const __default = self::ADMIN;
}
```

**2. Register it with Concord**

```php
// app/Providers/AppServiceProvider.php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Konekt\User\Contracts\UserType as UserTypeContract;
use App\UserType;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Replace the UserType enum with the app's one:
        $this->app->concord->registerEnum(
            UserTypeContract::class,
            UserType::class
        );
    }
}
```

### Use Completely Custom User Types

It's not mandatory to use any of the default user types, thus you can use your own, completely
custom UserType enum. The only requirements are:
- it's an [Enum](https://konekt.dev/enum),
- it implements the `UserType` interface,
- it has to be registered with Concord.

**1. Create your own enum class:**

```php
// app/UserType.php:
namespace App;

class UserType implements \Konekt\User\Contracts\UserType
{

    const __default = self::EMPLOYEE;

    const EMPLOYEE = 'employee';
    const BOSS     = 'boss';
}
```

**2. Register it with Concord**

```php
// app/Providers/AppServiceProvider.php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Konekt\User\Contracts\UserType as UserTypeContract;
use App\UserType;

class AppServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Replace the UserType enum with the app's one:
        $this->app->concord->registerEnum(
            UserTypeContract::class,
            UserType::class
        );
    }
}
```

---

**Next**: [Custom Models &raquo;](models.md)
