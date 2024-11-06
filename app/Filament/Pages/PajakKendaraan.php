<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use App\Models\Permohonan;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Tables\Concerns\InteractsWithTable;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;

class PajakKendaraan extends Page implements HasForms
{
    use InteractsWithForms;
    use HasPageShield;


    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.pajak-kendaraan';

    protected static ?string $navigationGroup = 'Tax Clerance';

    protected static ?int $navigationSort = 100;

    public $value; // Untuk input 'value'
    public $varcari = 'noreg'; // Untuk input 'varcari'
    public $result; // Untuk menyimpan hasil respons

    protected function getFormSchema(): array
    {
        return [
            Section::make('Cari informasi pajak kendaraan')
                ->schema([
                    Select::make('varcari')
                        ->options([
                            'noreg' => 'No. Polisi',
                            'nama' => 'Nama',
                        ])
                        ->label('Cari berdasarkan...'),
                    TextInput::make('value')
                        ->label('Search')
                        ->required(),
                ])->columns(2)
        ];
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label('Cari data...')
                ->submit('save')
        ];
    }


    public function submit()
    {
        $data = $this->form->getState();
        $response = Http::withBasicAuth(env('TAX_PAJAK_CLIENT_ID'), env('TAX_PAJAK_CLIENT_PW'))
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post(env('TAX_PAJAK_GET_SIGNATURE_ENDPOINT'), [
                'value' => $data['value'],
                'varcari' => $data['varcari'],
            ]);
        $body = $response->body();

        if (preg_match('/computed_signature: (.*)/', $body, $matches)) {
            $computedSignature = trim($matches[1]);
        } else {
            $computedSignature = 'Signature not found';
        }

        if ($computedSignature !== 'Signature not found') {
            $responseInfoPajak = Http::withBasicAuth(env('TAX_PAJAK_CLIENT_ID'), env('TAX_PAJAK_CLIENT_PW'))
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-Signature' => $computedSignature,
                ])
                ->post(env('TAX_PAJAK_GET_DATA_ENDPOINT'), [
                    'value' => $data['value'],
                    'varcari' => $data['varcari'],
                ]);

            $this->result = $responseInfoPajak->body();
            session()->flash('success', 'Data retrieved successfully!');
        } else {
            session()->flash('error', 'Signature not found');
            $this->result = null;
        }
    }
}
