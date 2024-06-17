<?php

namespace App\Filament\Resources\PerizinanConfigurationResource\Pages;

use App\Filament\Resources\PerizinanConfigurationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPerizinanConfiguration extends EditRecord
{
    protected static string $resource = PerizinanConfigurationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
