<?php

namespace App\Filament\Resources\FormulirResource\Pages;

use App\Filament\Resources\FormulirResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFormulirs extends ListRecords
{
    protected static string $resource = FormulirResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
