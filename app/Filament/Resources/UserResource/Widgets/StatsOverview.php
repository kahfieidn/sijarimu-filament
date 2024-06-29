<?php

namespace App\Filament\Resources\UserResource\Widgets;

use App\Models\Permohonan;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            //
            
            Stat::make('Jumlah Pengguna', User::all()->count())
                ->description('32% increase')
                ->color('warning')
                ->chart([17, 12, 15, 10, 30, 7, 40])
                ->descriptionIcon('heroicon-m-arrow-trending-up'),
            Stat::make('Permohonan Masuk', Permohonan::all()->count())
                ->description('7% decrease')
                ->color('info')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart([17, 12, 15, 10, 30, 7, 40]),
            Stat::make('Permohonan Selesai', Permohonan::where('status_permohonan_id', 11)->count())
                ->description('3% increase')
                ->color('success')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->descriptionIcon('heroicon-m-arrow-trending-up'),

        ];
    }
}
