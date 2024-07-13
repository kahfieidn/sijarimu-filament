<?php

namespace App\Filament\Resources\PermohonanResource\Pages;

use Filament\Actions;
use GuzzleHttp\Client;
use Filament\Forms\Get;
use Filament\Forms\Form;
use App\Models\Perizinan;
use App\Models\Permohonan;
use Illuminate\Http\Request;
use App\Models\StatusPermohonan;
use App\Models\PerizinanLifecycle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use App\Notifications\PermohonanCreated;
use Filament\Tables\Actions\CreateAction;
use App\Notifications\PermohonanCreatedWA;
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


        // Mengambil activity_log saat ini
        $currentActivityLog = $permohonan->activity_log;
        if (!is_array($currentActivityLog)) {
            $currentActivityLog = [];
        }
        // Menambahkan log baru ke activity_log
        $newLog = [
            'Activity' => 'Pemohon Membuat Permohonan',
            'Stake Holder' => auth()->user()->name,
            'Tanggal' => now()->format('d-m-Y H:i:s')
        ];
        $currentActivityLog[] = $newLog;
        $permohonan->update([
            'activity_log' => $currentActivityLog
        ]);

        //Notifyemail
        $permohonan->user->notify(new PermohonanCreated($permohonan));
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
