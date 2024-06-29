<?php

namespace App\Filament\Resources\PermohonanResource\Pages;

use Filament\Actions;
use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Models\Perizinan;
use App\Models\Permohonan;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Illuminate\Support\Facades\Session;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PermohonanResource;

class CreatePermohonan extends CreateRecord
{

    protected static string $resource = PermohonanResource::class;


    protected $listeners = ['refreshTabs' => 'refreshTabs'];

    public function refreshTabs()
    {
        $this->form->fill([
            'perizinan_id' => $this->form->getState()['perizinan_id'],
        ]);
    }


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        $perizinan = Perizinan::find($data['perizinan_id']);

        $data['is_using_template_izin'] = $perizinan->is_save_as_template_izin;

        return $data;
    }

    protected function afterCreate(): void
    {
        $permohonan = Permohonan::find($this->record->getKey());
        $perizinan = $permohonan->perizinan;
        $perizinanConfig = $perizinan->perizinan_configuration;

        // Tambahkan 1 ke nomor_izin
        $perizinanConfig->nomor_izin += 1;
        $perizinanConfig->nomor_rekomendasi += 1;

        // Simpan perubahan
        $perizinanConfig->save();
    }
}
