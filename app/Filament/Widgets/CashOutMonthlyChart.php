<?php

namespace App\Filament\Widgets;

use App\Models\CashOut;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Facades\DB;

class CashOutMonthlyChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected ?string $heading = 'Monthly Cash Out for This Year';

    protected static ?int $sort = 4;
    protected function getData(): array
    {
        $year = $this->pageFilters['year'] ?? date('Y');

        $data = CashOut::whereYear('created_at', $year)
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
