<?php

namespace App\Filament\Resources\TrackingResource\Pages;

use App\Filament\Resources\TrackingResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTracking extends ViewRecord
{
    protected static string $resource = TrackingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
