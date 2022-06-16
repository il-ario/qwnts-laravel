<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class UserCreateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {given_name} {family_name} {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $arguments = $this->arguments();
        $errors = false;

        if (strlen($arguments['password']) < 6) {
            $this->error("The password must be at least six characters.");
            $errors = true;
        }

        if (! preg_match("#[0-9]+#", $arguments['password'])) {
            $this->error("The password must contain at least one number.");
            $errors = true;
        }
        
        if (! preg_match("#[A-Z]+#", $arguments['password'])) {
            $this->error("The password must contain at least one uppercase letter.");
            $errors = true;
        }
        
        if (! preg_match("#[a-z]+#", $arguments['password'])) {
            $this->error("The password must contain at least one lowercase letter.");
            $errors = true;
        }
        
        if (! preg_match("/[,\.:;\-_$%&()=]/", $arguments['password'])) {
            $this->error("The password must contain at least one symbol.");
            $errors = true;
        }
        
        // Manca il controllo per i 2 caratteri identici consecutivi
        
        $localPart = strstr($arguments['email'], '@', true);
        if (preg_match("/{$localPart}/i", $arguments['password'])) {
            $this->error("The email local part not allowed in the password.");
            $errors = true;
        }

        /**
         * If the password pass the validations, make the new user
         */
        if (! $errors) {
            $user = new \App\Models\User;
        
            $user->given_name = $arguments['given_name'];
            $user->family_name = $arguments['family_name'];
            $user->email = $arguments['email'];
            $user->password = Hash::make($arguments['password']);
        
            $user->save();
    
            $this->info("User created.");
        } else {
            return;
        }
    }
}
