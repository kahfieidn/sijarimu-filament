<?php

namespace App\Filament\Resources\AssignPerizinanHandleResource\Pages;

use App\Filament\Resources\AssignPerizinanHandleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAssignPerizinanHandles extends ListRecords
{
    protected static string $resource = AssignPerizinanHandleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
