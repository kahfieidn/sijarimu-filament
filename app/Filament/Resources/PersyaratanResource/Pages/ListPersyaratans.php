<?php

namespace App\Filament\Resources\PersyaratanResource\Pages;

use App\Filament\Resources\PersyaratanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPersyaratans extends ListRecords
{
    protected static string $resource = PersyaratanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
