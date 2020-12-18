# User Related Events

The user module fires the following events:

- `UserWasCreated`
- `UserWasActivated`
- `UserWasInactivated`
- `UserWasDeleted`

All these events are implementing the `UserEvent` interface, ie. they have the `getUser()` method:

```php
public function getUser() : \Konekt\User\Contracts\User;
```

## Invitation Related Events

- `UserInvitationCreated`
- `UserIsBeingCreatedFromInvitation`
- `UserInvitationUtilized`

The first event only gets fired if the invitation is created with the `createInvitation` factory
method, ie. there are no lifecycle event hooks.

The second event gets fired if the `Invitation::createUser()` gets invoked.

These two events implement the `InvitationEvent` interface that can return the invitation object:

```php
$event->getInvitation();
```

When the `UserInvitationCreated` gets fired, the user does not yet exist.

`UserIsBeingCreatedFromInvitation` and `UserInvitationUtilized` events happen once a user is created
from the invitation, therefore these events also implement the `UserEvent` interface, and the
created/creating user can be obtained:

```php
$userInvitationUtilizedEvent->getInvitation(); // The invitation
$userInvitationUtilizedEvent->getUser(); // The user that has been/being created from the invitation
``` 

---

**Next**: [Customization &raquo;](customize.md)
