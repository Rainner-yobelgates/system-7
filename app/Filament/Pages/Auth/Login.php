<?php

namespace App\Filament\Pages\Auth;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Component;
use Filament\Forms\Components\TextInput;
use Illuminate\Validation\ValidationException;

class Login extends \Filament\Auth\Pages\Login
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getLoginFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ])
            ->statePath('data');
    }

    protected function getLoginFormComponent(): Component
    {
        return TextInput::make('name')
            ->label('Username')
            ->required()
            ->autocomplete()
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'name' => $data['name'],
            'password' => $data['password'],
        ];
    }
    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.name' => __('filament-panels::auth/pages/login.messages.failed'),
        ]);
    }
}
