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
- `UserInvitationUtilized`

The first event only gets fired if the invitation is created with the `createInvitation` factory
method, ie. there are no lifecycle event hooks.

The second event gets fired if the `Invitation::createUser()` gets invoked.

These two events implement the `InvitationEvent` interface that can return the invitation object:

```php
$event->getInvitation();
```

When the `UserInvitationCreated` gets fired, the user does not yet exist.
The `UserInvitationUtilized` happens once a user has been created from the invitation, therefore
this event also implements the `UserEvent` interface, and the created user can be obtained:

```php
$userInvitationUtilizedEvent->getInvitation(); // The invitation
$userInvitationUtilizedEvent->getUser(); // The user that has been created from the invitation
``` 

---

**Next**: [Customization &raquo;](customize.md)
