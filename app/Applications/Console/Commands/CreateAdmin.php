<?php

declare(strict_types=1);

namespace App\Applications\Console\Commands;

use Account\Models\Admin;
use Illuminate\Console\Command;
use Illuminate\Validation\Rule;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rules\Password;

use function Termwind\render;
use function Laravel\Prompts\text;
use function Laravel\Prompts\confirm;
use function Laravel\Prompts\password;

final class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Criar um novo administrador';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        /** @var Admin $admin */
        $admin = Admin::create($this->promptValidate());

        event(new Registered($admin));

        $this->info("Admin {$admin->name} criado com sucesso!");

        $token = $admin->createToken("Token Admin CLI for {$admin->name}", ['admin']);

        $this->infoResult($token->plainTextToken);

        return Command::SUCCESS;
    }

    private function promptValidate(): array
    {
        $name = text(
            label: 'Nome do admin',
            validate: ['name' => 'required|string|max:255']
        );

        $email = text(
            label: 'Email do admin',
            validate: ['email' => ['required', 'lowercase', 'email', 'max:255', Rule::unique(Admin::class, 'email')]]
        );

        $password = password(
            label: 'Qual a senha?',
            placeholder: 'password',
            validate: ['required', Password::defaults()],
            hint: 'Mínimo de 8 caracteres.'
        );

        password(
            label: 'Confirme a senha:',
            placeholder: 'password',
            validate: fn (string $value) => $value !== $password ? 'Senhas não coincidem.' : null
        );

        $isNotifiable = confirm(
            label: 'Deve ser notificado por e-mail?',
            default: false,
        );

        return array_merge(compact('name', 'email', 'password'), ['is_notifiable' => $isNotifiable]);
    }

    private function infoResult(string $token): void
    {
        render(<<<HTML
            <div class="text-sky-400">
                <br/>
                The token should be included in the <strong class="text-gray-100">"Authorization"</strong>
                header as a <strong class="text-gray-100">"Bearer"</strong> token:
                <br/>
                <br/>
                <em class="px-1 text-rose-500">{$token}</em>
            </div>
        HTML);
    }
}
