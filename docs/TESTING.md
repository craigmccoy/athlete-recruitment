# Testing Guide

Comprehensive testing documentation for the athlete recruitment website.

## 📋 Table of Contents

1. [Overview](#overview)
2. [Running Tests](#running-tests)
3. [Test Coverage](#test-coverage)
4. [Writing Tests](#writing-tests)
5. [Test Factories](#test-factories)
6. [Continuous Integration](#continuous-integration)

---

## Overview

The application includes comprehensive test coverage across:
- **Feature Tests** - End-to-end functionality testing
- **Unit Tests** - Model and helper class testing
- **Browser Tests** - (Optional) Frontend interaction testing

**Test Framework:** PHPUnit + Laravel Testing

---

## Running Tests

### Run All Tests

```bash
./vendor/bin/sail artisan test
```

### Run Specific Test Suite

```bash
# Feature tests only
./vendor/bin/sail artisan test --testsuite=Feature

# Unit tests only
./vendor/bin/sail artisan test --testsuite=Unit
```

### Run Specific Test File

```bash
./vendor/bin/sail artisan test tests/Feature/AthleteProfileTest.php
```

### Run Specific Test Method

```bash
./vendor/bin/sail artisan test --filter=homepage_displays_athlete_profile
```

### Run Tests with Coverage

```bash
./vendor/bin/sail artisan test --coverage
```

### Run Tests in Parallel (Faster)

```bash
./vendor/bin/sail artisan test --parallel
```

### Run OAuth Tests Only

```bash
# All OAuth-related tests
./vendor/bin/sail artisan test --filter=OAuth

# Just authentication tests
./vendor/bin/sail artisan test tests/Feature/OAuthAuthenticationTest.php

# Just management tests
./vendor/bin/sail artisan test tests/Feature/ManageOAuthConnectionsTest.php
```

---

## Test Coverage

### Feature Tests

#### ✅ Athlete Profile Tests (`AthleteProfileTest.php`)
- Homepage displays athlete profile
- Admin authentication and access control
- Profile creation and updates
- Image uploads
- Validation (name, GPA, email)
- Multi-sport support
- Social media links
- Caching behavior

#### ✅ Season Stats Tests (`SeasonStatTest.php`)
- Stats CRUD operations
- Yards per catch calculation
- Year validation
- Homepage display
- Caching behavior
- Sport inheritance from profile
- Ordering by year

#### ✅ Highlight Tests (`HighlightTest.php`)
- Highlight CRUD operations
- Featured highlight display
- Active/inactive filtering
- YouTube/Hudl/Vimeo URL support
- Caching behavior
- Title validation
- Ordering by order field

#### ✅ Award Tests (`AwardTest.php`)
- Award CRUD operations
- Homepage display
- Validation (title, year)
- Caching behavior
- Ordering by order field

#### ✅ Contact Form Tests (`ContactFormTest.php`)
- Form display and submission
- Email notifications
- Validation (name, email, message)
- Admin viewing submissions
- Mark as read functionality
- Delete submissions
- Form reset after submission

#### ✅ PDF Resume Tests (`PdfResumeTest.php`)
- PDF generation and download
- Athlete information inclusion
- Season stats in PDF
- Awards in PDF
- Sport display (multi-sport)
- Contact information
- Physical stats
- Career totals calculation
- Handling missing data

#### ✅ SEO Tests (`SeoTest.php`)
- Meta title and description
- Open Graph tags
- Twitter Card tags
- JSON-LD structured data
- Sitemap generation and validity
- Robots.txt configuration
- Canonical URL
- Sport-specific SEO

#### ✅ OAuth Authentication Tests (`OAuthAuthenticationTest.php`)
- Redirect to OAuth providers
- Invalid provider rejection
- Existing user login via OAuth
- Non-existing user denial
- Provider info updates on login
- Provider switching (GitHub → Google)
- OAuth exception handling
- Multiple provider support

#### ✅ OAuth Management Tests (`ManageOAuthConnectionsTest.php`)
- Display connected providers
- Show available providers when not connected
- Prevent unlinking without password
- Successful provider unlinking
- Hide section when no providers configured
- Detect available providers
- Filter enabled and configured providers

### Unit Tests

#### ✅ Athlete Profile Model Tests (`AthleteProfileModelTest.php`)
- Relationships (stats, highlights, awards)
- Type casting (arrays, booleans, decimals)
- Cache clearing on save/delete
- Multi-sport support

#### ✅ Sport Config Tests (`SportConfigTest.php`)
- Get all sports
- Get positions per sport (5 sports)
- Get stat fields per sport
- Get skills per sport
- Field configurations
- Default values

---

## Test Statistics

| Category | Tests | Coverage |
|----------|-------|----------|
| **Athlete Profile** | 12 | Full CRUD + validation |
| **Season Stats** | 10 | Full CRUD + calculations |
| **Highlights** | 11 | Full CRUD + video platforms |
| **Awards** | 9 | Full CRUD + display |
| **Contact Form** | 11 | Submission + notifications |
| **PDF Resume** | 10 | Generation + content |
| **SEO** | 13 | Meta tags + structured data |
| **OAuth Authentication** | 8 | Login + providers + errors |
| **OAuth Management** | 7 | Link/unlink + UI |
| **Unit Tests** | 13 | Models + helpers |
| **TOTAL** | **104+** | Comprehensive |

---

## Writing Tests

### Feature Test Template

```php
<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MyFeatureTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_does_something()
    {
        // Arrange
        $user = User::factory()->create();
        
        // Act
        $response = $this->actingAs($user)->get('/route');
        
        // Assert
        $response->assertStatus(200);
    }
}
```

### Unit Test Template

```php
<?php

namespace Tests\Unit;

use Tests\TestCase;

class MyUnitTest extends TestCase
{
    /** @test */
    public function it_returns_expected_value()
    {
        // Arrange
        $input = 'test';
        
        // Act
        $result = myFunction($input);
        
        // Assert
        $this->assertEquals('expected', $result);
    }
}
```

### Livewire Component Testing

```php
/** @test */
public function user_can_update_profile()
{
    $user = User::factory()->create();
    
    $this->actingAs($user)
        ->livewire('admin.manage-profile')
        ->set('name', 'New Name')
        ->call('save')
        ->assertHasNoErrors();
    
    $this->assertDatabaseHas('athlete_profiles', [
        'name' => 'New Name',
    ]);
}
```

### Testing File Uploads

```php
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/** @test */
public function user_can_upload_image()
{
    Storage::fake('public');
    $file = UploadedFile::fake()->image('photo.jpg');
    
    $this->actingAs($user)
        ->livewire('admin.manage-profile')
        ->set('profile_image', $file)
        ->call('save');
    
    Storage::disk('public')->assertExists($path);
}
```

### Testing Emails

```php
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmission;

/** @test */
public function form_sends_email()
{
    Mail::fake();
    
    $this->livewire('contact-form')
        ->set('email', 'test@example.com')
        ->call('submit');
    
    Mail::assertSent(ContactFormSubmission::class);
}
```

---

## Test Factories

Factories generate fake data for testing. All models have factories.

### Using Factories

```php
// Create single record
$profile = AthleteProfile::factory()->create();

// Create multiple records
$profiles = AthleteProfile::factory()->count(3)->create();

// Create with specific attributes
$profile = AthleteProfile::factory()->create([
    'name' => 'John Smith',
    'sport' => 'basketball',
]);

// Create without saving (make)
$profile = AthleteProfile::factory()->make();

// Use factory states
$basketball = AthleteProfile::factory()->basketball()->create();
$baseball = AthleteProfile::factory()->baseball()->create();
$inactive = AthleteProfile::factory()->inactive()->create();
```

### Available Factories

| Model | Factory | States |
|-------|---------|--------|
| `AthleteProfile` | `AthleteProfileFactory` | `inactive()`, `basketball()`, `baseball()` |
| `SeasonStat` | `SeasonStatFactory` | - |
| `Highlight` | `HighlightFactory` | `featured()`, `inactive()`, `hudl()` |
| `Award` | `AwardFactory` | - |
| `ContactSubmission` | `ContactSubmissionFactory` | `read()` |

### Creating Test Data

```php
// Complete athlete with stats
$profile = AthleteProfile::factory()
    ->has(SeasonStat::factory()->count(3))
    ->has(Award::factory()->count(5))
    ->has(Highlight::factory()->count(2))
    ->create();

// Featured basketball player
$player = AthleteProfile::factory()
    ->basketball()
    ->has(Highlight::factory()->featured())
    ->create();
```

---

## Best Practices

### 1. Use RefreshDatabase

Always use `RefreshDatabase` trait in tests that touch the database:

```php
use Illuminate\Foundation\Testing\RefreshDatabase;

class MyTest extends TestCase
{
    use RefreshDatabase;
}
```

### 2. Arrange-Act-Assert Pattern

Structure tests clearly:

```php
/** @test */
public function it_does_something()
{
    // Arrange - Set up test data
    $user = User::factory()->create();
    
    // Act - Perform the action
    $response = $this->actingAs($user)->get('/route');
    
    // Assert - Verify the outcome
    $response->assertStatus(200);
}
```

### 3. Descriptive Test Names

Use descriptive method names that explain what is being tested:

```php
// Good
public function authenticated_user_can_update_profile()

// Bad
public function test1()
```

### 4. Test One Thing

Each test should verify one specific behavior:

```php
// Good - Tests one thing
public function profile_requires_name()

// Bad - Tests multiple things
public function profile_validation()
```

### 5. Fake External Services

Always fake emails, storage, and external APIs:

```php
Mail::fake();
Storage::fake('public');
Http::fake();
```

---

## Continuous Integration

### GitHub Actions Example

```yaml
name: Tests

on: [push, pull_request]

jobs:
  test:
    runs-on: ubuntu-latest
    
    steps:
    - uses: actions/checkout@v2
    
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
    
    - name: Install Dependencies
      run: composer install
    
    - name: Run Tests
      run: php artisan test
```

---

## Troubleshooting

### Tests Failing Due to Cache

Clear cache before testing:

```bash
./vendor/bin/sail artisan config:clear
./vendor/bin/sail artisan cache:clear
```

### Database Issues

Refresh migrations:

```bash
./vendor/bin/sail artisan migrate:fresh
```

### Slow Tests

Run in parallel:

```bash
./vendor/bin/sail artisan test --parallel
```

### Memory Issues

Increase PHP memory limit in `phpunit.xml`:

```xml
<php>
    <env name="MEMORY_LIMIT" value="512M"/>
</php>
```

---

## Running Tests Before Deployment

### Pre-Deployment Checklist

```bash
# 1. Clear caches
./vendor/bin/sail artisan optimize:clear

# 2. Run all tests
./vendor/bin/sail artisan test

# 3. Check code style (if using Pint)
./vendor/bin/sail pint

# 4. Run static analysis (if using PHPStan/Larastan)
./vendor/bin/sail phpstan analyse

# 5. If all pass, deploy!
```

---

## Test Database Configuration

Tests use a separate database. Configuration in `phpunit.xml`:

```xml
<php>
    <env name="APP_ENV" value="testing"/>
    <env name="DB_CONNECTION" value="sqlite"/>
    <env name="DB_DATABASE" value=":memory:"/>
</php>
```

This ensures tests don't affect your development database.

---

## Additional Resources

- [Laravel Testing Documentation](https://laravel.com/docs/testing)
- [PHPUnit Documentation](https://phpunit.de/documentation.html)
- [Livewire Testing](https://livewire.laravel.com/docs/testing)
- [Laravel HTTP Tests](https://laravel.com/docs/http-tests)
