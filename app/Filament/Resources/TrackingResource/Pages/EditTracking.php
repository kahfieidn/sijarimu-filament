<?php

namespace App\Filament\Resources\TrackingResource\Pages;

use App\Filament\Resources\TrackingResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTracking extends EditRecord
{
    protected static string $resource = TrackingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
