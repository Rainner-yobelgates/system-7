<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class TransactionMonthlyChart extends ChartWidget
{
    protected static ?string $heading = 'Monthly Transactions for This Year';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $year = $this->filters['year'] ?? date('Y');

        $data = Transaction::whereYear('created_at', $year)
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
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
                    'label' => 'Transaction',
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
