<?php

namespace App\Filament\Resources\PermohonanResource\Pages;

use Filament\Actions;
use App\Models\Perizinan;
use App\Models\Permohonan;
use Illuminate\Support\Facades\Session;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PermohonanResource;

class CreatePermohonan extends CreateRecord
{

    protected static string $resource = PermohonanResource::class;
    protected $listeners = ['refresh' => 'refreshForm'];

    public function refreshForm()
    {
        $this->fillForm();
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        // $data['status_permohonan_id'] = 1;

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
