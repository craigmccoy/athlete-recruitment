<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserManagementCommandsTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function create_user_command_creates_user_with_options()
    {
        $this->artisan('user:create', [
            '--name' => 'Test User',
            '--email' => 'test@example.com',
            '--password' => 'password123',
        ])
            ->expectsQuestion('Create this user?', true)
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $user = User::where('email', 'test@example.com')->first();
        $this->assertTrue(Hash::check('password123', $user->password));
    }

    #[Test]
    public function create_user_command_prompts_for_all_fields()
    {
        $this->artisan('user:create')
            ->expectsQuestion('Name', 'Interactive User')
            ->expectsQuestion('Email', 'interactive@example.com')
            ->expectsQuestion('Password (min 8 characters)', 'password123')
            ->expectsQuestion('Confirm Password', 'password123')
            ->expectsQuestion('Create this user?', true)
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'name' => 'Interactive User',
            'email' => 'interactive@example.com',
        ]);
    }

    #[Test]
    public function create_user_command_fails_with_duplicate_email()
    {
        User::factory()->create(['email' => 'duplicate@example.com']);

        $this->artisan('user:create', [
            '--name' => 'Test User',
            '--email' => 'duplicate@example.com',
            '--password' => 'password123',
        ])
            ->expectsOutput('Validation failed:')
            ->assertExitCode(1);
    }

    #[Test]
    public function create_user_command_fails_with_invalid_email()
    {
        $this->artisan('user:create', [
            '--name' => 'Test User',
            '--email' => 'not-an-email',
            '--password' => 'password123',
        ])
            ->expectsOutput('Validation failed:')
            ->assertExitCode(1);
    }

    #[Test]
    public function create_user_command_fails_with_password_mismatch()
    {
        $this->artisan('user:create')
            ->expectsQuestion('Name', 'Test User')
            ->expectsQuestion('Email', 'test@example.com')
            ->expectsQuestion('Password (min 8 characters)', 'password123')
            ->expectsQuestion('Confirm Password', 'different456')
            ->expectsOutput('Passwords do not match!')
            ->assertExitCode(1);

        $this->assertDatabaseMissing('users', [
            'email' => 'test@example.com',
        ]);
    }

    #[Test]
    public function create_user_command_fails_with_short_password()
    {
        $this->artisan('user:create', [
            '--name' => 'Test User',
            '--email' => 'test@example.com',
            '--password' => 'short',
        ])
            ->expectsOutput('Password must be at least 8 characters long.')
            ->assertExitCode(1);
    }

    #[Test]
    public function create_user_command_can_be_cancelled()
    {
        $this->artisan('user:create', [
            '--name' => 'Test User',
            '--email' => 'test@example.com',
            '--password' => 'password123',
        ])
            ->expectsQuestion('Create this user?', false)
            ->assertExitCode(0);

        $this->assertDatabaseMissing('users', [
            'email' => 'test@example.com',
        ]);
    }

    #[Test]
    public function list_users_command_displays_all_users()
    {
        $user1 = User::factory()->create(['name' => 'Alice']);
        $user2 = User::factory()->create(['name' => 'Bob']);

        $this->artisan('user:list')
            ->expectsOutput('Total users: 2')
            ->assertExitCode(0);

        // Verify users exist in database
        $this->assertDatabaseHas('users', ['name' => 'Alice']);
        $this->assertDatabaseHas('users', ['name' => 'Bob']);
    }

    #[Test]
    public function list_users_command_shows_message_when_no_users()
    {
        $this->artisan('user:list')
            ->expectsOutput('No users found.')
            ->assertExitCode(0);
    }

    #[Test]
    public function reset_password_command_resets_user_password()
    {
        $user = User::factory()->create(['email' => 'test@example.com']);
        $oldPassword = $user->password;

        $this->artisan('user:reset-password', [
            'email' => 'test@example.com',
            '--password' => 'newpassword123',
        ])
            ->expectsQuestion('Reset password for "' . $user->name . '"?', true)
            ->assertExitCode(0);

        $user->refresh();
        $this->assertNotEquals($oldPassword, $user->password);
        $this->assertTrue(Hash::check('newpassword123', $user->password));
    }

    #[Test]
    public function reset_password_command_prompts_for_password()
    {
        $user = User::factory()->create(['email' => 'test@example.com']);

        $this->artisan('user:reset-password', ['email' => 'test@example.com'])
            ->expectsQuestion('New Password (min 8 characters)', 'newpassword123')
            ->expectsQuestion('Confirm New Password', 'newpassword123')
            ->expectsQuestion('Reset password for "' . $user->name . '"?', true)
            ->assertExitCode(0);

        $user->refresh();
        $this->assertTrue(Hash::check('newpassword123', $user->password));
    }

    #[Test]
    public function reset_password_command_fails_with_user_not_found()
    {
        $this->artisan('user:reset-password', ['email' => 'nonexistent@example.com'])
            ->expectsOutput('User not found with email: nonexistent@example.com')
            ->assertExitCode(1);
    }

    #[Test]
    public function reset_password_command_fails_with_password_mismatch()
    {
        $user = User::factory()->create(['email' => 'test@example.com']);

        $this->artisan('user:reset-password', ['email' => 'test@example.com'])
            ->expectsQuestion('New Password (min 8 characters)', 'password123')
            ->expectsQuestion('Confirm New Password', 'different456')
            ->expectsOutput('Passwords do not match!')
            ->assertExitCode(1);
    }

    #[Test]
    public function reset_password_command_fails_with_short_password()
    {
        $user = User::factory()->create(['email' => 'test@example.com']);

        $this->artisan('user:reset-password', [
            'email' => 'test@example.com',
            '--password' => 'short',
        ])
            ->expectsOutput('Password must be at least 8 characters long.')
            ->assertExitCode(1);
    }

    #[Test]
    public function reset_password_command_can_be_cancelled()
    {
        $user = User::factory()->create(['email' => 'test@example.com']);
        $oldPassword = $user->password;

        $this->artisan('user:reset-password', [
            'email' => 'test@example.com',
            '--password' => 'newpassword123',
        ])
            ->expectsQuestion('Reset password for "' . $user->name . '"?', false)
            ->assertExitCode(0);

        $user->refresh();
        $this->assertEquals($oldPassword, $user->password);
    }

    #[Test]
    public function delete_user_command_deletes_user()
    {
        $user = User::factory()->create(['email' => 'test@example.com']);

        $this->artisan('user:delete', ['email' => 'test@example.com'])
            ->expectsQuestion('Are you sure you want to delete this user? This action cannot be undone.', true)
            ->assertExitCode(0);

        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'email' => 'test@example.com',
        ]);
    }

    #[Test]
    public function delete_user_command_fails_with_user_not_found()
    {
        $this->artisan('user:delete', ['email' => 'nonexistent@example.com'])
            ->expectsOutput('User not found with email: nonexistent@example.com')
            ->assertExitCode(1);
    }

    #[Test]
    public function delete_user_command_can_be_cancelled()
    {
        $user = User::factory()->create(['email' => 'test@example.com']);

        $this->artisan('user:delete', ['email' => 'test@example.com'])
            ->expectsQuestion('Are you sure you want to delete this user? This action cannot be undone.', false)
            ->assertExitCode(0);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'email' => 'test@example.com',
        ]);
    }

    #[Test]
    public function delete_user_command_shows_user_details_before_deletion()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->artisan('user:delete', ['email' => 'test@example.com'])
            ->expectsOutput('You are about to delete the following user:')
            ->expectsQuestion('Are you sure you want to delete this user? This action cannot be undone.', false)
            ->assertExitCode(0);
        
        // Verify user still exists (deletion was cancelled)
        $this->assertDatabaseHas('users', ['id' => $user->id]);
    }
}
