<?php

namespace App\Filament\Resources\PermohonanResource\Pages;

use Filament\Actions;
use Illuminate\Database\Query\Builder;
use Filament\Resources\Pages\ListRecords;
use App\Filament\Resources\PermohonanResource;

class ListPermohonans extends ListRecords
{
    protected static string $resource = PermohonanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }


}
