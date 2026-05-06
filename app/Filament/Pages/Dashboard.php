<?php

namespace App\Filament\Pages;

use Filament\Schemas\Schema;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Forms\Components\Select;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    public function filtersForm(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('year')
                ->label('Tahun')
                ->options(
                    collect(range(now()->year - 5, now()->year))
                        ->mapWithKeys(fn ($year) => [$year => $year])
                )
                ->default(now()->year)
                ->native(true),
        ]);
    }
}