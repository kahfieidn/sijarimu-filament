<?php

namespace App\Filament\Resources\PersyaratanResource\Pages;

use App\Filament\Resources\PersyaratanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPersyaratan extends EditRecord
{
    protected static string $resource = PersyaratanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
