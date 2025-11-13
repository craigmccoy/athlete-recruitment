# User Management Commands

This guide explains how to manage user accounts using secure artisan commands.

## 📋 Available Commands

### 1. Create a New User

Create a new user account with interactive prompts:

```bash
./vendor/bin/sail artisan user:create
```

Or provide details via options:

```bash
./vendor/bin/sail artisan user:create --name="John Doe" --email="john@example.com"
```

**Generate a random secure password:**

```bash
./vendor/bin/sail artisan user:create --name="John Doe" --email="john@example.com" --random-password
```

This is useful for:
- Creating OAuth-only accounts (users login via Google/GitHub)
- Generating secure passwords to send separately
- Quick admin account creation

**Features:**
- ✅ Interactive prompts for name, email, and password
- ✅ Password confirmation (hidden input)
- ✅ Random password generation (16 characters with symbols)
- ✅ Email validation and duplicate checking
- ✅ Minimum password length validation (8 characters)
- ✅ Confirmation before creating user
- ✅ Secure password hashing

**Example:**
```bash
./vendor/bin/sail artisan user:create

Creating a new user account...

Name: John Doe
Email: john@example.com
Password (min 8 characters): ********
Confirm Password: ********

+----------+------------------+
| Field    | Value            |
+----------+------------------+
| Name     | John Doe         |
| Email    | john@example.com |
| Password | ********         |
+----------+------------------+

Create this user? (yes/no) [yes]: yes

✓ User created successfully!

User ID: 2
Name: John Doe
Email: john@example.com

You can now login at: http://localhost/login
```

**Example with Random Password:**
```bash
./vendor/bin/sail artisan user:create --name="Jane Smith" --email="jane@example.com" --random-password

Creating a new user account...

Generated secure random password

+----------+------------------+
| Field    | Value            |
+----------+------------------+
| Name     | Jane Smith       |
| Email    | jane@example.com |
| Password | **************** |
+----------+------------------+

Create this user? (yes/no) [yes]: yes

✓ User created successfully!

User ID: 3
Name: Jane Smith
Email: jane@example.com

⚠ IMPORTANT: Save this password securely!
Generated Password: Xk9$mP2nQ#7vR@4z

This password will not be shown again.

You can now login at: http://localhost/login
```

---

### 2. List All Users

View all registered users:

```bash
./vendor/bin/sail artisan user:list
```

**Output:**
```
+----+----------+------------------+---------------------+
| ID | Name     | Email            | Created At          |
+----+----------+------------------+---------------------+
| 2  | John Doe | john@example.com | 2025-11-11 10:15:30 |
| 1  | Admin    | admin@test.com   | 2025-11-10 08:00:00 |
+----+----------+------------------+---------------------+

Total users: 2
```

---

### 3. Reset User Password

Reset a user's password:

```bash
./vendor/bin/sail artisan user:reset-password john@example.com
```

Or provide the new password via option:

```bash
./vendor/bin/sail artisan user:reset-password john@example.com --password="newpassword123"
```

**Features:**
- ✅ Finds user by email
- ✅ Interactive password prompts (hidden input)
- ✅ Password confirmation
- ✅ Minimum password length validation
- ✅ Confirmation before resetting
- ✅ Secure password hashing

**Example:**
```bash
./vendor/bin/sail artisan user:reset-password john@example.com

Resetting password for: John Doe (john@example.com)

New Password (min 8 characters): ********
Confirm New Password: ********

Reset password for "John Doe"? (yes/no) [yes]: yes

✓ Password reset successfully for John Doe
User can now login with the new password at: http://localhost/login
```

---

### 4. Delete a User

Delete a user account:

```bash
./vendor/bin/sail artisan user:delete john@example.com
```

**Features:**
- ✅ Finds user by email
- ✅ Shows user details before deletion
- ✅ Confirmation required (defaults to "no")
- ✅ Permanent deletion warning

**Example:**
```bash
./vendor/bin/sail artisan user:delete john@example.com

You are about to delete the following user:
+----+----------+------------------+---------------------+
| ID | Name     | Email            | Created At          |
+----+----------+------------------+---------------------+
| 2  | John Doe | john@example.com | 2025-11-11 10:15:30 |
+----+----------+------------------+---------------------+

Are you sure you want to delete this user? This action cannot be undone. (yes/no) [no]: yes

✓ User "John Doe" has been deleted successfully.
```

---

## 🔒 Security Best Practices

### Password Requirements
- **Minimum 8 characters** (enforced by command)
- Passwords are **hashed** using bcrypt before storage
- Passwords are **never displayed** in plain text

### Safe Usage
1. **Never log passwords** - All password prompts use `secret()` method (hidden input)
2. **Confirm destructive actions** - Delete command requires explicit confirmation
3. **Validate email uniqueness** - Create command checks for duplicate emails
4. **Use strong passwords** - Recommended: 12+ characters with mixed case, numbers, symbols

---

## 🚀 Common Workflows

### Initial Setup - Create First Admin User

```bash
./vendor/bin/sail artisan user:create \
  --name="Site Administrator" \
  --email="admin@yoursite.com"
```

### Forgot Password Recovery

1. User contacts you requesting password reset
2. Verify user identity (outside of system)
3. Reset password:
   ```bash
   ./vendor/bin/sail artisan user:reset-password user@example.com
   ```
4. Provide temporary password to user securely
5. Advise user to change password after login

### User Audit

Check all registered users:
```bash
./vendor/bin/sail artisan user:list
```

### Remove Inactive User

```bash
./vendor/bin/sail artisan user:delete olduser@example.com
```

---

## 📝 Notes

- All commands should be run via Laravel Sail: `./vendor/bin/sail artisan user:...`
- Password prompts are hidden (secure input)
- All commands return exit codes: `0` for success, `1` for failure
- Commands include validation and error handling

---

## ⚙️ Advanced Options

### Create User in Scripts

For automation or seeding (use with caution):

```bash
./vendor/bin/sail artisan user:create \
  --name="Test User" \
  --email="test@example.com" \
  --password="securepassword123"
```

⚠️ **Warning:** Avoid hardcoding passwords in scripts. Use environment variables or secure vaults for automation.

### Create OAuth-Only Users

For users who will only authenticate via OAuth (Google, GitHub, etc.):

```bash
./vendor/bin/sail artisan user:create \
  --name="OAuth User" \
  --email="oauth@example.com" \
  --random-password
```

**Benefits:**
- ✅ User can login via OAuth immediately
- ✅ Secure random password set (required by database)
- ✅ Password displayed once for emergency access
- ✅ No need to communicate password to user

**Important Notes:**
- If you don't provide a password (use `--random-password`), the system will set a random password on **first OAuth login**
- This ensures database constraints are met
- Users can always reset their password via "Forgot Password" if needed
- The initial random password is only shown once during user creation

---

## 🛠️ Troubleshooting

### "User not found"
- Check email spelling
- List all users: `./vendor/bin/sail artisan user:list`

### "Validation failed: The email has already been taken"
- Email already exists in database
- Use different email or delete existing user first

### "Passwords do not match"
- Retype passwords carefully
- Password input is hidden for security

### "Password must be at least 8 characters"
- Increase password length to minimum 8 characters

---

## 🧪 Testing

All user management commands are fully tested. Run tests with:

```bash
./vendor/bin/sail artisan test --filter=UserManagementCommands
```

**Test Coverage:**
- ✅ User creation (with/without options)
- ✅ Email validation and duplicate checking
- ✅ Password validation and confirmation
- ✅ User listing (empty and populated)
- ✅ Password reset functionality
- ✅ User deletion with confirmation
- ✅ Cancellation flows
- ✅ Error handling and edge cases

See `tests/Feature/UserManagementCommandsTest.php` for all test cases.

---

## 📚 Related Documentation

- [Admin Guide](ADMIN_GUIDE.md) - Using the admin dashboard
- [TESTING.md](TESTING.md) - Complete testing guide
- [README.md](../README.md) - Project setup and overview
- [Laravel Jetstream Docs](https://jetstream.laravel.com) - Authentication features
