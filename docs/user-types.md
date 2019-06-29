# User Types

The `type` field is a `UserType` [enum](https://konekt.dev/enum) that can be either:

- 'client' (default)
- 'admin'
- 'api'

The type field was intended to be used for rough categorization of users and not for fine tuned
ACL type roles or permissions.

Examples what the type can be used for:

- Generic access/denial to areas of a system eg. Backoffice, REST API.
- Segregating users on the UI or in Reports
- Enabling special actions eg. only admins can impersonate other users.

> Check out our [ACL](https://konekt.dev/acl) package for a proper granular permission system that
> works in combination with this package.

For modifying possible user types refer to [Customization](customize.md)

---

**Next**: [Profile &raquo;](profile.md)
