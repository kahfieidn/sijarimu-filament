<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Formulir;
use Filament\Forms\Form;
use App\Models\Perizinan;
use App\Models\Permohonan;
use Filament\Tables\Table;
use App\Models\Persyaratan;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PermohonanResource\Pages;
use App\Filament\Resources\PermohonanResource\RelationManagers;
use App\Filament\Resources\PermohonanResource\Pages\CreatePermohonan;

class PermohonanResource extends Resource
{
    protected static ?string $model = Permohonan::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-on-square-stack';

    protected static ?string $navigationGroup = 'Pengajuan';

    protected static ?int $navigationGroupSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Pilih Jenis Perizinan')
                        ->schema([
                            Forms\Components\Select::make('perizinan_id')
                                ->relationship(name: 'perizinan', titleAttribute: 'nama_perizinan')
                                ->live()
                                ->preload()
                                ->searchable()
                                ->afterStateUpdated(function ($livewire, Set $set, Get $get, $state) {
                                    $possible_flows = ['pilih_perizinan', 'profile_usaha', 'checklist_berkas', 'checklist_formulir'];
                                    foreach ($possible_flows as $flow_name) {
                                        $set($flow_name, false);
                                    }
                                    $set('berkas.*.nama_persyaratan', '');
                                    $set('berkas.*.file', null);

                                    $perizinan = Perizinan::find($get('perizinan_id'));
                                    if ($perizinan != null) {
                                        $flows = $perizinan->perizinan_lifecycle->flow;
                                        if ($perizinan->perizinan_lifecycle_id) {
                                            foreach ($flows as $item) {
                                                if (isset($item['flow'])) {
                                                    $flow_name = $item['flow'];
                                                    $set($flow_name, true);
                                                }
                                            }
                                        }
                                    }
                                })
                        ]),
                    Wizard\Step::make('Unggah Berkas')
                        ->visible(fn (Get $get) => $get('checklist_berkas'))
                        ->schema([
                            Repeater::make('berkas')
                                ->schema(function (Get $get): array {
                                    $selectedOptions = collect($get('berkas.*.nama_persyaratan'))->filter();
                                    return [
                                        Select::make('nama_persyaratan')
                                            ->options(function () use ($get) {
                                                $data = Persyaratan::whereIn('perizinan_id', function ($query) use ($get) {
                                                    $query->select('perizinan_id')
                                                        ->from('perizinans')
                                                        ->where('perizinan_id', $get('perizinan_id'));
                                                })->pluck('nama_persyaratan', 'id');
                                                return $data;
                                            })
                                            ->disableOptionWhen(function ($value, $state, Get $get) use ($selectedOptions) {
                                                return $selectedOptions->contains($value);
                                            })
                                            ->live()
                                            ->preload(),
                                        Forms\Components\FileUpload::make('file')
                                            ->required()
                                            ->openable()
                                            ->appendFiles()
                                            ->directory('berkas'),

                                    ];
                                })->columns(2),
                        ]),
                    Wizard\Step::make('Formulir')
                        ->visible(fn (Get $get) => $get('checklist_formulir'))
                        ->schema(function (Get $get): array {
                            $options = Formulir::whereIn('perizinan_id', function ($query) use ($get) {
                                $query->select('perizinan_id')
                                    ->from('formulirs')
                                    ->where('perizinan_id', $get('perizinan_id'));
                            })->get();
                            $selectOptions = [];
                            foreach ($options as $key => $option) {
                                if ($option->type == 'string') {
                                    if ($option->role_id == 2 && auth()->user()->roles->first()->id == 2 || auth()->user()->roles->first()->id != 2) {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\TextInput::make('formulir.' . $option->nama_formulir)
                                            ->required();
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } else if ($option->type == 'date') {
                                    if ($option->role_id == 2 && auth()->user()->roles->first()->id == 2 || auth()->user()->roles->first()->id != 2) {
                                        $selectOptions[$option->nama_formulir] = Forms\Components\DatePicker::make('formulir.' . $option->nama_formulir);
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } else if ($option->type == 'select') {
                                    if ($option->role_id == 2 && auth()->user()->roles->first()->id == 2 || auth()->user()->roles->first()->id != 2) {
                                        $jsonOptions = $option->options;
                                        $valuesArray = array_map(function ($item) {
                                            return $item['value'];
                                        }, $jsonOptions);
                                        $selectOptions[$option->nama_formulir] = Forms\Components\Select::make('formulir.' . $option->nama_formulir)
                                            ->options(array_combine($valuesArray, $valuesArray)) // Menggunakan array_combine agar value menjadi key dan value
                                            ->required();
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                }
                            }
                            return [
                                ...$selectOptions
                            ];
                        }),
                    Wizard\Step::make('Profile Usaha')
                        ->visible(fn (Get $get) => $get('profile_usaha') == true)
                        ->schema([
                            Forms\Components\TextInput::make('additional_field')
                                ->label('Field Tambahan')
                                ->required(),
                            Forms\Components\TextInput::make('sdsd')
                                ->required()
                                ->maxLength(255),
                        ]),
                    Wizard\Step::make('Konfirmasi Data')
                        ->schema([
                            Placeholder::make('konfirmasi_keabsahan_data')
                                ->content('Kami menyatakan bahwa data tersebut telah diperiksa secara cermat dan dinyatakan benar adanya sesuai dengan sumber yang tersedia. Kami juga menegaskan bahwa kami bertanggung jawab penuh atas keakuratan dan keabsahan data ini ke depannya, serta siap untuk mengklarifikasi atau memperbaiki jika ditemukan ketidaksesuaian di kemudian hari.'),
                            Forms\Components\Checkbox::make('saya_setuju')
                                ->accepted()
                        ]),
                ])->columnSpanFull(),
            ]);
            
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('perizinan.nama_perizinan')
                    ->sortable(),
                Tables\Columns\TextColumn::make('perizinan.sektor.nama_sektor')
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_permohonan.nama_status')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //

            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        if (auth()->user()->roles->first()->name == 'super_admin') {
            return $query;
        } else if (auth()->user()->roles->first()->name == 'pemohon') {
            return $query->where('user_id', auth()->id());
        } else if (auth()->user()->roles->first()->name == 'front_office') {
            return $query->where('status_permohonan_id', 1);
        }
    }



    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPermohonans::route('/'),
            'create' => Pages\CreatePermohonan::route('/create'),
            'view' => Pages\ViewPermohonan::route('/{record}'),
            'edit' => Pages\EditPermohonan::route('/{record}/edit'),
        ];
    }
}
