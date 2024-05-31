<?php

namespace App\Filament\Resources\StatusPermohonanResource\Pages;

use App\Filament\Resources\StatusPermohonanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStatusPermohonan extends EditRecord
{
    protected static string $resource = StatusPermohonanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
