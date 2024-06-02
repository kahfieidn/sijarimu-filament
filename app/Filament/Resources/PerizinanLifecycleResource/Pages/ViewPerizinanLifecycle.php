<?php

namespace App\Filament\Resources\PerizinanLifecycleResource\Pages;

use App\Filament\Resources\PerizinanLifecycleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPerizinanLifecycle extends ViewRecord
{
    protected static string $resource = PerizinanLifecycleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
