<?php

namespace App\Filament\Resources\TypePerizinanResource\Pages;

use App\Filament\Resources\TypePerizinanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTypePerizinans extends ListRecords
{
    protected static string $resource = TypePerizinanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
