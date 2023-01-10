# User Types

The `type` field is a `UserType` [enum](https://konekt.dev/enum).

The package ships with some defaults, but it's fully customizable.
The out-of-box user types are:

- *client* (default)
- *admin*
- *api*

The `type` field was intended to be used for **rough categorization of users** and not for fine tuned
ACL type roles or permissions.

Examples what `type` can be used for:

- Coarse level access/denial to areas of a system eg. Backoffice, REST API.
- Segregating users on the UI or in Reports
- Enabling special actions eg. only admins can impersonate other users.

> Check out our [ACL](https://konekt.dev/acl) package for a proper granular permission system that
> works in combination with this package.

## Customizing User Types

For modifying possible user type values refer to [Customization](customize.md).

---

**Next**: [Invitations &raquo;](invitations.md)
