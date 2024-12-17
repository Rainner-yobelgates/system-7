<?php

namespace App\Filament\Widgets;

use App\Models\CashOut;
use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TransactionsProfitsMonthlyChart extends ChartWidget
{
    protected static ?string $heading = 'Monthly Profits for This Year';
    protected static ?int $sort = 3;
    protected function getData(): array
    {
        $revenueData = Transaction::whereYear('created_at', date('Y')) 
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total) as total'))
            ->groupBy('month')
            ->get();
        $expenseData = CashOut::whereYear('created_at', date('Y'))
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(amount) as total'))
            ->groupBy('month')
            ->get();
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        
        $revenueArray = array_fill(0, 12, 0);
        $expenseArray = array_fill(0, 12, 0);
        $profitArray = array_fill(0, 12, 0);

        foreach ($revenueData as $item) {
            $revenueArray[$item->month - 1] = $item->total;
        }
        foreach ($expenseData as $item) {
            $expenseArray[$item->month - 1] = $item->total;
        }
        for ($i = 0; $i < 12; $i++) {
            $profitArray[$i] = $revenueArray[$i] - $expenseArray[$i];
        }
        
        return [
            'datasets' => [
                [
                    'label' => 'Income',
                    'data' => $revenueArray,
                    'backgroundColor' => 'rgba(76, 175, 80, 0.25)',
                    'borderColor' => '#4CAF50',
                ],
                [
                    'label' => 'Profits',
                    'data' => $profitArray,
                ],
            ],
            'labels' => $months,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
