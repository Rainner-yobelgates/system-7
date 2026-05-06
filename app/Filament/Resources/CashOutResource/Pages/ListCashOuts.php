<?php

namespace App\Filament\Resources\CashOutResource\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Resources\CashOutResource;
use Filament\Resources\Pages\ListRecords;

class ListCashOuts extends ListRecords
{
    protected static string $resource = CashOutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
