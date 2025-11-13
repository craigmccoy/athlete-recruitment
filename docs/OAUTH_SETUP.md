# OAuth Setup Guide

## Quick Start

**Important:** Only existing users can log in via OAuth. Users must be created in the admin panel first with an email that matches their OAuth provider email.

### 1. Run Migration

```bash
php artisan migrate
```

### 2. Configure Google OAuth

1. Visit [Google Cloud Console](https://console.cloud.google.com/)
2. Create/select project → **APIs & Services** → **Credentials**
3. Create **OAuth 2.0 Client ID** (Web application)
4. Add redirect URI: `http://localhost:8000/auth/google/callback`
5. Copy **Client ID** and **Client Secret**

### 3. Add to `.env`

```env
GOOGLE_CLIENT_ID=your-client-id-here
GOOGLE_CLIENT_SECRET=your-secret-here
GOOGLE_REDIRECT_URL="${APP_URL}/auth/google/callback"
```

### 4. Clear Cache & Test

```bash
php artisan config:clear
```

Visit `/login` and click "Sign in with Google"

---

## Configuration Options

### OAuth Provider Settings

Control which providers are available in `.env`:

```env
# Enable/disable specific OAuth providers
OAUTH_GOOGLE_ENABLED=true
OAUTH_GITHUB_ENABLED=false
OAUTH_FACEBOOK_ENABLED=false
OAUTH_TWITTER_ENABLED=false
OAUTH_LINKEDIN_ENABLED=false
```

**Note:** Providers will only show on login if:
- ✅ Enabled in `.env`
- ✅ Properly configured in `config/services.php`
- ✅ Valid credentials exist

### Email/Password Login

Disable traditional login to force OAuth-only:

```env
EMAIL_LOGIN_ENABLED=false
```

When disabled:
- Email/password fields hidden on login page
- Users can only authenticate via OAuth
- Useful for organizations with SSO requirements

---

## Managing OAuth Connections

Users can manage their OAuth connections in their profile:

1. Go to **Profile** → **OAuth Connections**
2. View linked provider and when it was connected
3. **Unlink provider** (requires password to be set first)
4. **Link new provider** if none connected

### Security Note

Users must have a password set before unlinking OAuth. This prevents account lockout.

---

## How It Works

✅ User clicks "Sign in with Google"  
✅ Redirects to Google for authentication  
✅ Google redirects back to `/auth/google/callback`  
✅ System checks if user email exists in database  
✅ If exists: 
   - Sets random password if user doesn't have one
   - Saves OAuth provider info
   - Login successful → redirects to dashboard  
❌ If not: Shows error message

**Note:** OAuth users automatically get a secure random password set on first login if they don't have one. This ensures database constraints are met and provides emergency access.

---

## Adding More Providers

The system supports: `google`, `github`, `facebook`, `twitter`, `linkedin`

### Example: Adding GitHub

**1. Get Credentials:**
- GitHub Settings → Developer settings → OAuth Apps → New
- Callback: `http://localhost:8000/auth/github/callback`

**2. Add to `config/services.php`:**
```php
'github' => [
    'client_id' => env('GITHUB_CLIENT_ID'),
    'client_secret' => env('GITHUB_CLIENT_SECRET'),
    'redirect' => env('APP_URL') . '/auth/github/callback',
],
```

**3. Add to `.env`:**
```env
GITHUB_CLIENT_ID=your-github-client-id
GITHUB_CLIENT_SECRET=your-github-secret
```

**4. Add button to `resources/views/auth/login.blade.php`:**
```blade
<a href="{{ route('social.redirect', ['provider' => 'github']) }}">
    Sign in with GitHub
</a>
```

---

## Troubleshooting

**"Authentication failed"**
- Verify credentials in `.env`
- Check redirect URL in provider console
- Run `php artisan config:clear`

**"No account found"**
- User must exist in database first
- Email must match exactly (case-sensitive)

**"Redirect URI mismatch"**
- Ensure provider console URL matches exactly: `http://localhost:8000/auth/google/callback`
- Include protocol (`http://` or `https://`)

---

## Technical Details

**Routes:**
- `/auth/{provider}/redirect` - Redirects to OAuth provider
- `/auth/{provider}/callback` - Handles OAuth callback

**Database Fields:**
- `provider` - Provider name (google, github, etc.)
- `provider_id` - Unique ID from provider
- `provider_linked_at` - Timestamp

**Files:**
- Controller: `app/Http/Controllers/SocialAuthController.php`
- Migration: `database/migrations/2025_11_12_004700_add_oauth_provider_to_users_table.php`
- Routes: `routes/web.php`
- Config: `config/services.php` (provider credentials)
- Config: `config/fortify.php` (OAuth & email login settings)
