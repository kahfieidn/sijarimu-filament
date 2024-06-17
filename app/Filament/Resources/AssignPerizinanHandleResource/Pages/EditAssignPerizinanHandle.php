<?php

namespace App\Filament\Resources\AssignPerizinanHandleResource\Pages;

use App\Filament\Resources\AssignPerizinanHandleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAssignPerizinanHandle extends EditRecord
{
    protected static string $resource = AssignPerizinanHandleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
