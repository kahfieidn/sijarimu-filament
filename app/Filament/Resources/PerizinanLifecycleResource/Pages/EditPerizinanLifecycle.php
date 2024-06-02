<?php

namespace App\Filament\Resources\PerizinanLifecycleResource\Pages;

use App\Filament\Resources\PerizinanLifecycleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPerizinanLifecycle extends EditRecord
{
    protected static string $resource = PerizinanLifecycleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
