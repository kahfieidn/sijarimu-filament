<?php

namespace App\Filament\Resources\PermohonanResource\Pages;

use Carbon\Carbon;
use Filament\Actions;
use App\Models\Perizinan;
use App\Models\Permohonan;
use App\Models\Persyaratan;
use App\Models\StatusPermohonan;
use Filament\Infolists\Infolist;
use App\Models\PerizinanLifecycle;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\View\View;
use Infolists\Components\TextEntry;
use Filament\Support\Enums\MaxWidth;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Storage;
use Filament\Resources\Pages\EditRecord;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use App\Filament\Resources\PermohonanResource;
use App\Notifications\PermohonanDone;
use App\Notifications\PermohonanRejected;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class EditPermohonan extends EditRecord
{
    protected static string $resource = PermohonanResource::class;
    protected static ?string $title = 'Tinjau Permohonan';

    public function mount(string | int $record): void
    {
        $permohonan = Permohonan::findOrFail($record); // Fetch the Permohonan record by ID
        if ($permohonan->status_permohonan_id != 2 && auth()->user()->roles->first()->name == 'pemohon') {
            abort(403);
        }
        parent::mount($record);
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $perizinan = Perizinan::find($data['perizinan_id']);
        $flows = $perizinan->perizinan_lifecycle->flow;
        $role = auth()->user()->roles->first()->id;
        $permohonan = Permohonan::find($data['id']);

        $data['tanggal_izin_terbit'] = Carbon::now()->format('Y-m-d');
        $data['tanggal_rekomendasi_terbit'] = Carbon::now()->format('Y-m-d');
        $data['tanda_tangan_permintaan_rekomendasi'] = $this->record->is_using_template_izin ? 'is_template_rekomendasi' : 'is_manual_rekomendasi';
        $data['tanda_tangan_izin'] = $this->record->is_using_template_izin ? 'is_template_izin' : 'is_manual_izin';
        $data['is_catatan_kesimpulan'] = $this->record->catatan_kesimpulan ? '1' : '0';

        // Get Status Permohonan ID from Edit Permohonan
        $perizinan_lifecycle_id = Perizinan::where('id', $data['perizinan_id'])->pluck('perizinan_lifecycle_id')->first();
        $data_lifecycle = PerizinanLifecycle::where('id', $perizinan_lifecycle_id)
            ->pluck('flow_status');
        $options_select_permohonan_id = [];
        foreach ($data_lifecycle as $item) {
            foreach ($item as $roleData) {
                if ($roleData['condition_status'] == $data['status_permohonan_id'] && $roleData['role'] == auth()->user()->roles->first()->id) {
                    $options_select_permohonan_id = $roleData['status'];
                    break;
                } else if ($roleData['condition_status'] == null && $roleData['role'] == auth()->user()->roles->first()->id) {
                    $options_select_permohonan_id = $roleData['status'];
                    break;
                }
            }
        }
        $final_relation_status_id = StatusPermohonan::whereIn('id', $options_select_permohonan_id)->pluck('id', 'id')->toArray();
        $final_relation_status_name = StatusPermohonan::whereIn('id', $options_select_permohonan_id)->pluck('nama_status', 'id')->toArray();
        $data['final_relation_status_id'] = $final_relation_status_id;
        $data['final_relation_status_name'] = $final_relation_status_name;

        //Handle pesan back office
        if ($this->record->message_bo != null) {
            $permohonan->update([
                'message_bo' => null,
            ]);
        }


        if ($perizinan->perizinan_lifecycle_id) {
            foreach ($flows as $item) {
                if (isset($item['flow'])) {
                    $flow_name = $item['flow'];

                    if (in_array("$role", $item['role_id']) && $item['condition_status'] == null) {
                        $data[$flow_name] = true;
                    } else if (in_array("$role", $item['role_id']) && $item['condition_status'] == $data['status_permohonan_id']) {
                        $data[$flow_name] = true;
                    }
                }
            }
        }
        $data['status_permohonan_id_from_edit'] = $data['status_permohonan_id'];

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $perizinan_lifecycle_id = Perizinan::where('id', $data['perizinan_id'])->pluck('perizinan_lifecycle_id')->first();

        $flow_status = PerizinanLifecycle::where('id', $perizinan_lifecycle_id)
            ->pluck('flow_status');
        $options = null;
        foreach ($flow_status as $item) {
            foreach ($item as $roleData) {
                if ($roleData['role'] == auth()->user()->roles->first()->id) {
                    $options = $roleData['default_status'];
                    break 2;
                }
            }
        }

        //Set status permohonan unggah berkas to default status
        if (auth()->user()->roles->first()->name == 'pemohon' && $data['status_permohonan_id'] == 2) {
            foreach ($data['berkas'] as &$berkas) {
                $berkas['status'] = "Pending";
                $berkas['keterangan'] = "-";
            }
            $data['message'] = null;
            $data['status_permohonan_id'] = $options;
        }
        return $data;
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $currentMonthYear = Carbon::now()->format('Y-F');
        $permohonan = Permohonan::find($record->id);

        if (isset($data['tanda_tangan_permintaan_rekomendasi'])) {
            if ($data['tanda_tangan_permintaan_rekomendasi'] == 'is_template_rekomendasi') {
                $pdfData = [
                    'permohonan' => $permohonan,
                ];
                $storageDirectory = 'rekomendasi/' . $currentMonthYear . '/' . $permohonan->id . '.pdf';
                $pdf = FacadePdf::loadView('cetak.rekomendasi.request', $pdfData);
                $customPaper = [0, 0, 609.4488, 935.433];
                $pdf->set_paper($customPaper);

                $fileContent = $pdf->output();
                $hashedFileName = hash('sha256', $storageDirectory) . '.' . pathinfo($storageDirectory, PATHINFO_EXTENSION);

                Storage::put('public/rekomendasi/' . $currentMonthYear . '/' . $hashedFileName, $fileContent);
                $permohonan->update([
                    'rekomendasi' => 'rekomendasi/' . $currentMonthYear . '/' . $hashedFileName,
                ]);
            }
        }

        if (isset($data['tanda_tangan_izin'])) {
            $record->is_using_template_izin = ($data['tanda_tangan_izin'] == 'is_template_izin') ? 1 : 0;
            if ($data['tanda_tangan_izin'] == 'is_template_izin') {
                $pdfData = [
                    'permohonan' => $permohonan,
                ];
                $storageDirectory = 'izin_terbit/' . $currentMonthYear . '/' . $permohonan->id . '.pdf';
                $pdf = FacadePdf::loadView('cetak.izin.request', $pdfData);
                $customPaper = [0, 0, 609.4488, 935.433];
                $pdf->set_paper($customPaper);

                $fileContent = $pdf->output();
                $hashedFileName = hash('sha256', $storageDirectory) . '.' . pathinfo($storageDirectory, PATHINFO_EXTENSION);

                Storage::put('public/izin_terbit/' . $currentMonthYear . '/' . $hashedFileName, $fileContent);
                $permohonan->update([
                    'izin_terbit' => 'izin_terbit/' . $currentMonthYear . '/' . $hashedFileName,
                ]);
            }
        }

        // Mengambil activity_log saat ini
        $currentActivityLog = $permohonan->activity_log;
        if (!is_array($currentActivityLog)) {
            $currentActivityLog = [];
        }

        // Menambahkan log baru ke activity_log
        $newLog = [
            'Activity' => StatusPermohonan::find($this->record['status_permohonan_id'])->nama_status,
            'Stake Holder' => auth()->user()->name,
            'Tanggal' => now()->format('d-m-Y H:i:s')
        ];
        $currentActivityLog[] = $newLog;

        // Menyimpan kembali activity_log yang sudah diperbarui
        $permohonan->update([
            'activity_log' => $currentActivityLog
        ]);

        $record->update($data);
        return $record;
    }


    protected function afterSave(): void
    {
        $currentMonthYear = Carbon::now()->format('Y-F');
        $permohonan = Permohonan::find($this->record->id);

        if ($this->record['status_permohonan_id'] == 7 && $this->record['is_using_template_izin'] == 1) {
            $pdfData = [
                'permohonan' => $permohonan,
            ];
            $storageDirectory = 'rekomendasi_terbit/' . $currentMonthYear . '/' . $permohonan->id . '.pdf';
            $pdf = FacadePdf::loadView('cetak.rekomendasi.request', $pdfData);
            $customPaper = [0, 0, 609.4488, 935.433];
            $pdf->set_paper($customPaper);

            $fileContent = $pdf->output();
            $hashedFileName = hash('sha256', $storageDirectory) . '.' . pathinfo($storageDirectory, PATHINFO_EXTENSION);

            Storage::put('public/rekomendasi_terbit/' . $currentMonthYear . '/' . $hashedFileName, $fileContent);
            $permohonan->update([
                'rekomendasi_terbit' => 'rekomendasi_terbit/' . $currentMonthYear . '/' . $hashedFileName,
            ]);
        }

        if ($this->record['status_permohonan_id'] == 11 && $this->record['is_using_template_izin'] == 1) {
            $pdfData = [
                'permohonan' => $permohonan,
            ];
            $storageDirectory = 'izin_terbit/' . $currentMonthYear . '/' . $permohonan->id . '.pdf';
            $pdf = FacadePdf::loadView('cetak.izin.request', $pdfData);
            $customPaper = [0, 0, 609.4488, 935.433];
            $pdf->set_paper($customPaper);

            $fileContent = $pdf->output();
            $hashedFileName = hash('sha256', $storageDirectory) . '.' . pathinfo($storageDirectory, PATHINFO_EXTENSION);

            Storage::put('public/izin_terbit/' . $currentMonthYear . '/' . $hashedFileName, $fileContent);
            $permohonan->update([
                'izin_terbit' => 'izin_terbit/' . $currentMonthYear . '/' . $hashedFileName,
            ]);
        }


        //Notify Email
        if ($this->record['status_permohonan_id'] == 11) {
            $permohonan->user->notify(new PermohonanDone($permohonan));
        } else if ($this->record['status_permohonan_id'] == 2) {
            $permohonan->user->notify(new PermohonanRejected($permohonan));
        }

    }



    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make()
                ->visible(fn ($record) => auth()->user()->roles->first()->name == 'super_admin'),
            Actions\ViewAction::make(),

            Actions\Action::make('Draft Rekomendasi')
                ->visible(fn (Permohonan $record): bool => in_array($record->status_permohonan_id, [4, 5, 6]) && $record->perizinan->is_template_rekomendasi == 1)
                ->url(fn (Permohonan $record): string => route('app.cetak.permintaan-rekomendasi-request', $record))
                ->openUrlInNewTab(),

            //Real Rekomendasi
            Actions\Action::make('Permintaan Rekomendasi')
                ->visible(fn (Permohonan $record): bool => in_array($record->status_permohonan_id, [5, 6, 7, 8, 9, 10, 11]) && !is_null($record->rekomendasi_terbit))
                ->url(fn (Permohonan $record): string => url('storage/' . $record->rekomendasi_terbit))
                ->openUrlInNewTab(),
            //Kajian Teknis
            Actions\Action::make('Kajian Teknis')
                ->visible(fn (Permohonan $record): bool => in_array($record->status_permohonan_id, [8, 9, 10, 11]) && !is_null($record->kajian_teknis))
                ->url(fn (Permohonan $record): string => url('storage/' . $record->kajian_teknis))
                ->openUrlInNewTab(),



            //Draft Izin Template For Manual
            // Actions\Action::make('Draft Izin')
            //     ->visible(fn (Permohonan $record): bool => in_array($record->status_permohonan_id, [8]) && $record->perizinan->is_template_izin == 1)
            //     ->url(fn (Permohonan $record): string => route('app.cetak.izin.request', $record))
            //     ->openUrlInNewTab(),
            //Draft Izin For Automatic
            Actions\Action::make('Draft Izin')
                ->visible(fn (Permohonan $record): bool => in_array($record->status_permohonan_id, [8, 9, 10]) && $record->is_using_template_izin == 1)
                ->url(fn (Permohonan $record): string => route('app.cetak.izin.request', $record))
                ->openUrlInNewTab(),
            //Izin Manual
            Actions\Action::make('Izin')
                ->visible(fn (Permohonan $record): bool => in_array($record->status_permohonan_id, [9, 10, 11]) && $record->is_using_template_izin == 0)
                ->url(fn (Permohonan $record): string => url('storage/' . $record->izin_terbit))
                ->openUrlInNewTab(),
            Actions\Action::make('Izin')
                ->visible(fn (Permohonan $record): bool => in_array($record->status_permohonan_id, [11]) && $record->is_using_template_izin == 1)
                ->url(fn (Permohonan $record): string => route('app.cetak.izin.request', $record))
                ->openUrlInNewTab()
        ];
    }


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
