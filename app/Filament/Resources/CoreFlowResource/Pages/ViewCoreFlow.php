<?php

namespace App\Filament\Resources\CoreFlowResource\Pages;

use App\Filament\Resources\CoreFlowResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCoreFlow extends ViewRecord
{
    protected static string $resource = CoreFlowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
