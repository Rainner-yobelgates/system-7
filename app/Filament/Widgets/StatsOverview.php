<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Transaction', Transaction::whereYear('created_at', date('Y'))->count())->description('Total transaction in this year ('. date('Y') .')')->descriptionIcon('heroicon-m-information-circle', IconPosition::Before),
            Stat::make('Total Profits', number_format(Transaction::whereYear('created_at', date('Y'))->sum('total')))->description('Total profits in this year ('. date('Y') .')')->descriptionIcon('heroicon-m-information-circle', IconPosition::Before),
            Stat::make('Transaction incomplete', Transaction::where('status', 'Belum Diambil')->whereYear('created_at', date('Y'))->count())->description('Total transaction incomplete in this year ('. date('Y') .')')->descriptionIcon('heroicon-m-information-circle', IconPosition::Before),
        ];
    }
}
