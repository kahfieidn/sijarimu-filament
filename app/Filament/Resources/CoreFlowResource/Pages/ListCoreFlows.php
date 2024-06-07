<?php

namespace App\Filament\Resources\CoreFlowResource\Pages;

use App\Filament\Resources\CoreFlowResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCoreFlows extends ListRecords
{
    protected static string $resource = CoreFlowResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
