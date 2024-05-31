<?php

namespace App\Filament\Resources\SektorResource\Pages;

use App\Filament\Resources\SektorResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSektors extends ListRecords
{
    protected static string $resource = SektorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
