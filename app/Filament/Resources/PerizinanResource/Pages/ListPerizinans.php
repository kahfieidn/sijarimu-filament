<?php

namespace App\Filament\Resources\PerizinanResource\Pages;

use App\Filament\Resources\PerizinanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPerizinans extends ListRecords
{
    protected static string $resource = PerizinanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
