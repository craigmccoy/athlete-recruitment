<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create 
                            {--name= : The name of the user}
                            {--email= : The email address}
                            {--password= : The password (will be prompted if not provided)}
                            {--random-password : Generate a secure random password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user account';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating a new user account...');
        $this->newLine();

        // Get user details
        $name = $this->option('name') ?: $this->ask('Name');
        $email = $this->option('email') ?: $this->ask('Email');
        
        // Validate email and check if it already exists
        $validator = Validator::make(
            ['email' => $email],
            ['email' => 'required|email|unique:users,email']
        );

        if ($validator->fails()) {
            $this->error('Validation failed:');
            foreach ($validator->errors()->all() as $error) {
                $this->error('  - ' . $error);
            }
            return 1;
        }

        // Get password securely
        $useRandomPassword = $this->option('random-password');
        $password = null;
        $generatedPassword = false;
        
        if ($useRandomPassword) {
            // Generate secure random password
            $password = Str::password(16, true, true, true);
            $generatedPassword = true;
            $this->info('Generated secure random password');
        } else {
            $password = $this->option('password');
            
            if (!$password) {
                $password = $this->secret('Password (min 8 characters)');
                $passwordConfirmation = $this->secret('Confirm Password');
                
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
        }

        // Confirm creation
        $this->newLine();
        $this->table(
            ['Field', 'Value'],
            [
                ['Name', $name],
                ['Email', $email],
                ['Password', str_repeat('*', strlen($password))],
            ]
        );

        if (!$this->confirm('Create this user?', true)) {
            $this->info('User creation cancelled.');
            return 0;
        }

        // Create user
        try {
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            $this->newLine();
            $this->info('✓ User created successfully!');
            $this->newLine();
            $this->line('User ID: ' . $user->id);
            $this->line('Name: ' . $user->name);
            $this->line('Email: ' . $user->email);
            
            if ($generatedPassword) {
                $this->newLine();
                $this->warn('⚠ IMPORTANT: Save this password securely!');
                $this->line('Generated Password: ' . $password);
                $this->newLine();
                $this->comment('This password will not be shown again.');
            }
            
            $this->newLine();
            $this->comment('You can now login at: ' . url('/login'));

            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to create user: ' . $e->getMessage());
            return 1;
        }
    }
}
