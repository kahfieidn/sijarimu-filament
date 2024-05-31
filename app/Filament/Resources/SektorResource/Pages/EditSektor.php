<?php

namespace App\Filament\Resources\SektorResource\Pages;

use App\Filament\Resources\SektorResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSektor extends EditRecord
{
    protected static string $resource = SektorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
