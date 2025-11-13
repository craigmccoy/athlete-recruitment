<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class DeleteUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:delete {email : The email address of the user to delete}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete a user account';

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

        $this->newLine();
        $this->warn('You are about to delete the following user:');
        $this->table(
            ['ID', 'Name', 'Email', 'Created At'],
            [
                [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->created_at->format('Y-m-d H:i:s'),
                ]
            ]
        );

        if (!$this->confirm('Are you sure you want to delete this user? This action cannot be undone.', false)) {
            $this->info('User deletion cancelled.');
            return 0;
        }

        try {
            $userName = $user->name;
            $user->delete();

            $this->newLine();
            $this->info('✓ User "' . $userName . '" has been deleted successfully.');

            return 0;
        } catch (\Exception $e) {
            $this->error('Failed to delete user: ' . $e->getMessage());
            return 1;
        }
    }
}
