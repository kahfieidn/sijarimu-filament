<?php

namespace App\Filament\Resources\SektorResource\Pages;

use App\Filament\Resources\SektorResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewSektor extends ViewRecord
{
    protected static string $resource = SektorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
