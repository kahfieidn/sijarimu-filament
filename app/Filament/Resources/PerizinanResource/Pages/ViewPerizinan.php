<?php

namespace App\Filament\Resources\PerizinanResource\Pages;

use App\Filament\Resources\PerizinanResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPerizinan extends ViewRecord
{
    protected static string $resource = PerizinanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
