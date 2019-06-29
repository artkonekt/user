# Active/Inactive Status

The `User` model has an `is_active` boolean attribute, that is true by
default for newly created users.

You can inactivate a user with the following method:

```php
$user->inactivate();
```

This will emit a `UserWasInactivated` event.

An inactive user can be activated with:

```php
$user->activate();
```

This will emit a `UserWasActivated` event.

---

**Next**: [Login Statistics &raquo;](login-stats.md)
