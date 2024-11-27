<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create {name} {email} {password} {--admin}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Criar um novo usuário no sistema';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $email = $this->argument('email');
        $password = $this->argument('password');
        $isAdmin = $this->option('admin');

        // Verificar se o usuário já existe
        if (User::where('email', $email)->exists()) {
            $this->error('Usuário com o email ' . $email . ' já existe.');
            return 1;
        }

        // Criar o novo usuário
        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => bcrypt($password),
            'is_admin' => $isAdmin,
        ]);

        $this->info('Usuário criado com sucesso: ' . $user->email);
        return 0;
    }
}