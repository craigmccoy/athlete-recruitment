<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ResetUserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:reset-password 
                            {email : The email address of the user}
                            {--password= : The new password (will be prompted if not provided)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset a user\'s password';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error('User not found with email: ' . $email);
            return 1;
        }

        $this->info('Resetting password for: ' . $user->name . ' (' . $user->email . ')');
        $this->newLine();

        // Get new password securely
        $password = $this->option('password');
        
        if (!$password) {
            $password = $this->secret('New Password (min 8 characters)');
            $passwordConfirmation = $this->secret('Confirm New Password');
            
            if ($password !== $passwordConfirmation) {
                $this->error('Passwords do not match!');
                return 1;
            }
        }

        // Validate password
        if (strlen($password) < 8) {
            $this->error('Password must be at least 8 characters long.');
            return 1;
        }

        if (!$this->confirm('Reset password for "' . $user->name . '"?', true)) {
            $this->info('Password reset cancelled.');
            return 0;
        }

        try {
            $user->password = Hash::make($password);
            $user->save();

            $this->newLine();
            $this->info('✓ Password reset successfully for ' . $user->name);
            $this->comment('User can now login with the new password at: ' . url('/login'));

            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to reset password: ' . $e->getMessage());
            return 1;
        }
    }
}
