<?php

namespace App\Filament\Resources\PermohonanResource\Widgets;

use App\Models\Permohonan;
use Filament\Widgets\ChartWidget;

class PermohonanChart extends ChartWidget
{
    protected static ?string $heading = 'Permohonan Masuk';
    protected int | string | array $columnSpan = 'full';

    protected function getData(): array
    {
        $januari = Permohonan::whereMonth('created_at', 1)->get();
        $februari = Permohonan::whereMonth('created_at', 2)->get();
        $maret = Permohonan::whereMonth('created_at', 3)->get();
        $april = Permohonan::whereMonth('created_at', 4)->get();
        $mei = Permohonan::whereMonth('created_at', 5)->get();
        $juni = Permohonan::whereMonth('created_at', 6)->get();
        $juli = Permohonan::whereMonth('created_at', 7)->get();
        $agustus = Permohonan::whereMonth('created_at', 8)->get();
        $september = Permohonan::whereMonth('created_at', 9)->get();
        $oktober = Permohonan::whereMonth('created_at', 10)->get();
        $november = Permohonan::whereMonth('created_at', 11)->get();
        $desember = Permohonan::whereMonth('created_at', 12)->get();
        return [
            'datasets' => [
                [
                    'label' => 'Permohonan Masuk',
                    'data' => [$januari->count(), $februari->count(), $maret->count(), $april->count(), $mei->count(), $juni->count(), $juli->count(), $agustus->count(), $september->count(), $oktober->count(), $november->count(), $desember->count()],
                    'backgroundColor' => '#36A2EB',
                    'borderColor' => '#9BD0F5',
                ],
            ],
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    
}
