<?php

namespace App\Filament\Resources\StatusPermohonanResource\Pages;

use App\Filament\Resources\StatusPermohonanResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewStatusPermohonan extends ViewRecord
{
    protected static string $resource = StatusPermohonanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
