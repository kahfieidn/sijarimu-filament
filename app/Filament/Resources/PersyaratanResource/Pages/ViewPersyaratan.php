<?php

namespace App\Filament\Resources\PersyaratanResource\Pages;

use App\Filament\Resources\PersyaratanResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPersyaratan extends ViewRecord
{
    protected static string $resource = PersyaratanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
