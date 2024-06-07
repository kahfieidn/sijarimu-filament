<?php

namespace App\Filament\Resources\CoreFlowResource\Pages;

use App\Filament\Resources\CoreFlowResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCoreFlow extends EditRecord
{
    protected static string $resource = CoreFlowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
