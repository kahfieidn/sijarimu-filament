<?php

namespace App\Filament\Resources\PerizinanConfigurationResource\Pages;

use App\Filament\Resources\PerizinanConfigurationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPerizinanConfigurations extends ListRecords
{
    protected static string $resource = PerizinanConfigurationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
