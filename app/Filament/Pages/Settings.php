<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Actions\Action;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Exceptions\Halt;

class Settings extends Page
{
    public ?array $data = [];
    protected static ?string $navigationIcon = 'heroicon-o-wrench';

    protected static string $view = 'filament.pages.settings';
    protected static ?int $navigationSort = 4;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('logo')
                    ->image()
                    ->directory('logo')
                    ->imageEditor()
                    ->imageEditorAspectRatios([
                        null,
                        '16:9',
                        '4:3',
                        '1:1',
                    ]),
                Textarea::make('alamat')
                ->placeholder('Masukkan alamat')
                ->label('Alamat Toko')
                ->rows(5)
                ->columnSpan(2),
                TextInput::make('no_telp')
                ->mask('9999-9999-9999')
                ->rule('regex:/^[0-9\-]+$/')
                ->placeholder('Masukkan nomor telepon')
                ->label('No Telepon'),
            ])
            ->statePath('data');
    }
    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Save')
                ->submit('save'),
        ];
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();
            Setting::updateOrCreate(
                ['id' => 1],
                $data
            );
        } catch (Halt $exception) {
            return;
        }

        Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();
    }
}
