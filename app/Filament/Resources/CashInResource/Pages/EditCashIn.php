<?php

namespace App\Filament\Resources\CashInResource\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Resources\CashInResource;
use Filament\Resources\Pages\EditRecord;

class EditCashIn extends EditRecord
{
    protected static string $resource = CashInResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
