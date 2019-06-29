# User Related Events

The user module fires the following events:

- `UserWasCreated`
- `UserWasActivated`
- `UserWasInactivated`
- `UserWasDeleted`

All events are implementing the `UserEvent` interface, ie. they have the `getUser()` method:

```php
public function getUser() : \Konekt\User\Contracts\User;
```
