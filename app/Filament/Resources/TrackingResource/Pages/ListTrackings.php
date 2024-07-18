<?php

namespace App\Filament\Resources\TrackingResource\Pages;

use Closure;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\TrackingResource;

class ListTrackings extends ListRecords
{
    protected static string $resource = TrackingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\CreateAction::make(),
        ];
    }
}
