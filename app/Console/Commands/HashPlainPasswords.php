<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class HashPlainPasswords extends Command
{
    /**
     * Название и сигнатура команды
     *
     * @var string
     */
    protected $signature = 'users:hash-plain-passwords';

    /**
     * Описание команды
     *
     * @var string
     */
    protected $description = 'Хэширует все пароли пользователей, сохранённые в базе в открытом виде';

    /**
     * Выполнение команды
     */
    public function handle()
    {
        $this->info('Начинаю обработку пользователей...');

        $count = 0;

        User::chunk(100, function ($users) use (&$count) {
            foreach ($users as $user) {
                // Проверяем, что пароль ещё не bcrypt
                if (!str_starts_with($user->password, '$2y$')) {
                    $plain = $user->password;
                    $user->password = Hash::make($plain);
                    $user->save();

                    $this->line("Пароль пользователя ID {$user->id} захеширован");
                    $count++;
                }
            }
        });

        $this->info("Готово! Захешировано {$count} паролей.");
        return Command::SUCCESS;
    }
}
