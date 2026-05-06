<?php

namespace App\Filament\Widgets;

use App\Models\CashIn;
use App\Models\CashOut;
use App\Models\Transaction;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    use InteractsWithPageFilters;
    
    protected static ?int $sort = 1;
    protected function getStats(): array
    {
        $year = $this->pageFilters['year'] ?? date('Y');
        $getYearTransaction = Transaction::whereYear('created_at', $year)->count();
        $getYearIncome = Transaction::whereYear('created_at', $year)->sum('total');
        $getYearCashIn = CashIn::whereYear('created_at', $year)->sum('amount');
        $getYearCashOut = CashOut::whereYear('created_at', $year)->sum('amount');
        $getTransIncomplete = Transaction::where('status', 'Belum Diambil')->whereYear('created_at', $year)->count();
        return [
            Stat::make('Total Transaction', $getYearTransaction)->description('Total transaction in this year')->descriptionIcon('heroicon-m-information-circle', IconPosition::Before),
            Stat::make('Total Profits (Income: ' . number_format($getYearIncome + $getYearCashIn) . ')', number_format(($getYearIncome + $getYearCashIn) - $getYearCashOut))->description("Total profits in this year")->descriptionIcon('heroicon-m-information-circle', IconPosition::Before),
            Stat::make('Total Cash Out', number_format($getYearCashOut))->description('Total cash out in this year')->descriptionIcon('heroicon-m-information-circle', IconPosition::Before),
            Stat::make('Transaction incomplete', $getTransIncomplete)->description('Total transaction incomplete')->descriptionIcon('heroicon-m-information-circle', IconPosition::Before),
        ];
    }
}
