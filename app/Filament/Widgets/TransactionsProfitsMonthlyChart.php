<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TransactionsProfitsMonthlyChart extends ChartWidget
{
    protected static ?string $heading = 'Monthly Profits for This Year';

    protected function getData(): array
    {
        $data = Transaction::whereYear('created_at', date('Y')) 
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total) as total'))
            ->groupBy('month')
            ->get();
        
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        
        $transactionData = array_fill(0, 12, 0);
        foreach ($data as $item) {
            $transactionData[$item->month - 1] = $item->total;
        }
        
        return [
            'datasets' => [
                [
                    'label' => 'Produk',
                    'data' => $transactionData,
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
