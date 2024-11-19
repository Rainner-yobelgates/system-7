<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Widgets\ChartWidget;

class TransactionsProfitsMonthlyChart extends ChartWidget
{
    protected static ?string $heading = 'Monthly Profits for This Year';

    protected function getData(): array
    {
        $data = Transaction::get()
        ->groupBy(function($date) {
            return $date->created_at->format('M');
        });

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        $transactionData = [];

        foreach ($months as $month) {
            $transactionData[] = $data->has($month) ? $data->get($month)->sum('total') : 0;
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
