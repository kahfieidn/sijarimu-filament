<?php

namespace App\Filament\Resources\PermohonanResource\Pages;

use Filament\Panel;
use Filament\Forms\Form;
use Filament\Resources\Pages\Page;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Components\TextInput;
use App\Filament\Resources\PermohonanResource;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;


class DraftIzin extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = PermohonanResource::class;

    protected static string $view = 'filament.resources.permohonan-resource.pages.sample';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function getFormSchema(): array{
        return [
            Section::make('Data Pemohon')
            ->schema([
                TextInput::make('nama_pemohon')
                    ->required()
                    ->maxLength(255),
            ]),
        ];
    }

}
