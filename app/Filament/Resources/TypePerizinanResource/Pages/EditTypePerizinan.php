<?php

namespace App\Filament\Resources\TypePerizinanResource\Pages;

use App\Filament\Resources\TypePerizinanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTypePerizinan extends EditRecord
{
    protected static string $resource = TypePerizinanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
