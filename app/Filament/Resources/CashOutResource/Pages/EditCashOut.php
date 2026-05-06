<?php

namespace App\Filament\Resources\CashOutResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\CashOutResource;
use Filament\Resources\Pages\EditRecord;

class EditCashOut extends EditRecord
{
    protected static string $resource = CashOutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
