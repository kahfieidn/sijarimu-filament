<?php

namespace App\Filament\Resources\AssignPerizinanHandleResource\Pages;

use App\Filament\Resources\AssignPerizinanHandleResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewAssignPerizinanHandle extends ViewRecord
{
    protected static string $resource = AssignPerizinanHandleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
