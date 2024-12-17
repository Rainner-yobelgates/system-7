<?php

namespace App\Filament\Widgets;

use App\Models\CashOut;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class CashOutMonthlyChart extends ChartWidget
{
    protected static ?string $heading = 'Monthly Cash Out for This Year';

    protected static ?int $sort = 4;
    protected function getData(): array
    {
        $data = CashOut::whereYear('created_at', date('Y')) 
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(amount) as amount'))
            ->groupBy('month')
            ->get();
        
        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        
        $cashOutData = array_fill(0, 12, 0);
        foreach ($data as $item) {
            $cashOutData[$item->month - 1] = $item->amount;
        }

        return [
           'datasets' => [
                [
                    'label' => 'Cash Out',
                    'data' => $cashOutData,
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
