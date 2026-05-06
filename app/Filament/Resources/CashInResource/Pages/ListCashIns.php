<?php

namespace App\Filament\Resources\CashInResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\CashInResource;
use Filament\Resources\Pages\ListRecords;

class ListCashIns extends ListRecords
{
    protected static string $resource = CashInResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
