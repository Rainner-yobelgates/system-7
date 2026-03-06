<?php

namespace App\Filament\Pages;

use Filament\Forms\Form;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Forms\Components\Select;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    public function filtersForm(Form $form): Form
    {
        return $form->schema([
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