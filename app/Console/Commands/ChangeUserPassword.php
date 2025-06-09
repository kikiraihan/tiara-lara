<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ChangeUserPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:change-password {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change the password for a user with the given email';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Get the email and password from the command arguments
        $email = $this->argument('email');
        $newPassword = $this->argument('password');

        // Find the user by email
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("User with email {$email} not found.");
            return 1;
        }

        // Update the user's password
        $user->password = Hash::make($newPassword);
        $user->save();

        $this->info("Password for user {$email} has been updated successfully.");
        return 0;
    }
}
