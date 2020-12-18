# Invitations

This library provides a simple tooling for inviting users to your application using a large enough
custom hash.

The intended workflow is the following:

- Create an invitation
- Send the link to the user that contains the hash
- User clicks the link
- Invitation gets resolved by the hash in the link
- Unless the invitation is expired, your app displays a form to the user where they can enter their
  password, and other arbitrary data your app needs
- User submits the form, that still contains the hash
- Your code looks up the invitation by hash (again) and creates the user from the invitation and
  from the submitted form data
- The invitation gets marked as utilized, and a reference to the created user is saved in the invitation
- The invitation becomes invalid and can't be used

Invitations minimally require an email address to be set.

## Create an Invitation

The `Invitation` class is a simple Eloquent model that gets stored in the `invitations` database
table. Thus, you can simply use the well known Eloquent methods to create new entries.

But the recommended way is to use the built-in `createInvitation()` factory method:

```php
$invitation = Invitation::createInvitation('email@example.org');
echo $invitation->hash;
// 722a165526a746d98e6ede0c34c86735cd997dfa61e94b3dad4cfa8d0d5e7ae867784a3fceec41b1810ab948dc642dab
```

### Predefine Attributes in the Invitation

Your application may want to set further data for the future user. This can be useful when you want
to create a user with a given name, type, in a given group or with a predefined set or permissions.

This package supports the `type` and the `name` fields natively, but you can define arbitrary data
in the options array:

```php
Invitation::createInvitation('email@example.com', 'John Doe', UserType::ADMIN(), ['role' => 'superadmin']);
```

## Expiration of Invitations

Invitations expire after a certain period of time.

The expiration date can be read from the `$invitation->expires_at` property, which returns a Carbon
object.

The default expiration days is set in the module config, with a default value of 30 days:

```php
config('konekt.user.invitation.default_expiry_days');
// 30
```

Change the value of this configuration entry to use another default days of expiry. 

It is also possible to explicitly define expiration date for each invitation. 

The last parameter of the invitation factory method is the expiration of the invitation in days:

```php
Invitation::createInvitation('email@example.com', null, null, [], 25); // Invitation expires after 25 days
```

Alternatively, you can modify it directly:

```php
$invitation = Invitation::createInvitation('john@doe.org');
$invitation->expires_at = Carbon::tomorrow();
$invitation->save();
```

To check whether an invitation is expired, there are two methods available:

```php
$invitation->isExpired();
$invitation->isNotExpired();
```

## Create Users from Invitations

Once your app receives input from the invitee, it can create a user from the Invitation:

```php
Invitation::createInvitation('giovanni@gatto.it', 'Giovanni Gatto', UserType::ADMIN(), ['role' => 'superadmin']);

// ... invitation gets sent,
// user opens it and
// submits the form:

$invitation = Invitation::findByHash($request->get('hash'));
$user = $invitation->createUser(['password' => $request->get('password')]);
echo $user->email;
// giovanni@gatto.it
echo $user->name;
// Giovanni Gatto
echo $user->type;
// Admin
```

The contents of the options array (`['role' => 'superadmin']`) is not processed by this library, but
it's available for your application, and you can apply your logic based on what's in the array.

### Hooking Into User Creation

In case you want your app to hook into user creation from invitation, you can write listeners for
the related events

#### User Is Being Created Event

The `UserIsBeingCreatedFromInvitation` gets fired when the user data is filled but not yet saved.
If you define a listener to this event, you can manipulate the user object before it gets saved
(assuming your listener is synchronous). The event will contain a user that doesn't yet have an id.

**Example Listener**

```php
class PrependsPizzaToUserName
{
    public function handle(UserIsBeingCreatedFromInvitation $event)
    {
        $user = $event->getUser();
        $user->name = 'Pizza ' . $user->name;
        // Don't call the $user->save() method here
    }
}
```

#### User Invitation Utilized

The `UserInvitationUtilized` (aka User Created from Invitation) event gets fired **after** a user
gets created (based on an invitation). The event will contain a persisted user, that already has an
id.

**Example Listener**

```php
class CreatesAProfileFromInvitation
{
    public function handle(UserInvitationUtilized $event)
    {
        $user = $event->getUser();
        $invitation = $event->getInvitation();
        $person = Person::create([
            'firstname' => $invitation->options['firstname'],
            'lastname'  => $invitation->options['lastname'],
        ]);

        $user->profile()->create(['person_id' => $person->id]);
    }
}
```

## The Created User

If a user gets created from the invitation using the `createUser()` method, the created user gets
automatically assigned to the Invitation and can be retrieved:

```php
$invitation->getTheCreatedUser(); // returns a user object
```

## Check for Utilization

It is possible to obtain whether an invitation has been utilized:

```php
$invitation->hasBeenUtilizedAlready();
// false
$invitation->hasNotBeenUtilizedYet();
// true

$invitation->createUser();
$invitation->hasBeenUtilizedAlready();
// true
```

The date of the utilization can be retrieved as well:

```php
echo $invitaton->utilized_at->format('M d, Y');
// Dec 18, 2020
```

## Invitation Validity

An Invitation is considered to be valid if it:

- hasn't been utilized yet (ie. no user was created from it)
- hasn't expired yet

To check for validity, use the following methods:

```php
$invitation->isStillValid();
$invitation->isNoLongerValid();
```

## Invitation Events

There are three Invitation event classes:

- `UserInvitationCreated`
- `UserIsBeingCreatedFromInvitation`
- `UserInvitationUtilized`

See the [Events](events.md) page for more details about Invitation related events.

---

**Next**: [Profiles &raquo;](profile.md)
