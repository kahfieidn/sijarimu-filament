<?php

namespace App\Filament\Resources;

use Carbon\Carbon;
use Filament\Forms;
use Filament\Tables;
use App\Models\Feature;
use Filament\Forms\Get;
use Filament\Forms\Set;
use App\Models\Formulir;
use Filament\Forms\Form;
use App\Models\Perizinan;
use App\Models\Permohonan;
use Filament\Tables\Table;
use App\Models\Persyaratan;
use App\Models\StatusPermohonan;
use Filament\Resources\Resource;
use App\Models\PerizinanLifecycle;
use Filament\Tables\Filters\Filter;
use App\Models\AssignPerizinanHandle;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\TrackingExporter;
use Filament\Forms\Components\Placeholder;
use Custom\Path\Models\Permohonan\Tracking;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Components\Actions\Action;
use App\Filament\Resources\TrackingResource\Pages;
use Filament\Infolists\Components\RepeatableEntry;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TrackingResource\RelationManagers;

class TrackingResource extends Resource
{
    protected static ?string $model = Permohonan::class;
    protected static ?string $navigationIcon = 'heroicon-o-magnifying-glass';
    protected static ?string $pluralModelLabel = 'Tracking';
    protected static ?string $navigationGroup = 'Pengajuan';
    protected static ?int $navigationGroupSort = 2;

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
                                    $possible_flows = Feature::all()->pluck('nama_feature')->toArray();
                                    foreach ($possible_flows as $flow_name) {
                                        $set($flow_name, false);
                                    }

                                    $set('berkas.*.nama_persyaratan', '');
                                    $set('berkas.*.file', null);
                                    $perizinan = Perizinan::find($get('perizinan_id'));

                                    //Setting default select status_permohonan_id dynamic form
                                    $perizinan_lifecycle_id = Perizinan::where('id', $get('perizinan_id'))->pluck('perizinan_lifecycle_id')->first();
                                    $data = PerizinanLifecycle::where('id', $perizinan_lifecycle_id)
                                        ->pluck('flow_status');
                                    $options = null;
                                    if ($perizinan) {
                                        foreach ($data as $item) {
                                            foreach ($item as $roleData) {
                                                if ($roleData['role'] == auth()->user()->roles->first()->id) {
                                                    $options = $roleData['default_status'];
                                                    break 2;
                                                }
                                            }
                                        }
                                    }
                                    $set('status_permohonan_id', $options);

                                    //Setting default Nomor Izin && Nomor Rekomendasi
                                    $set('nomor_rekomendasi', $perizinan->perizinan_configuration->prefix_nomor_rekomendasi . $perizinan->perizinan_configuration->nomor_rekomendasi . $perizinan->perizinan_configuration->suffix_nomor_rekomendasi);
                                    $set('nomor_izin', $perizinan->perizinan_configuration->prefix_nomor_izin . $perizinan->perizinan_configuration->nomor_izin . $perizinan->perizinan_configuration->suffix_nomor_izin);


                                    $role = auth()->user()->roles->first()->id;

                                    if ($perizinan != null) {
                                        $flows = $perizinan->perizinan_lifecycle->flow;
                                        if ($perizinan->perizinan_lifecycle_id) {
                                            foreach ($flows as $item) {
                                                if (isset($item['flow'])) {
                                                    $flow_name = $item['flow'];
                                                    if (in_array("$role", $item['role_id'])) {
                                                        $set($flow_name, true);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                })
                                ->required()
                                ->disabledOn('edit')->dehydrated(),
                        ]),
                    Wizard\Step::make('Profile Usaha')
                        ->visible(fn (Get $get) => $get('profile_usaha_relation'))
                        ->schema([
                            Fieldset::make('Profile Usaha')
                                ->relationship('profile_usaha')
                                ->schema([
                                    Forms\Components\TextInput::make('nama_perusahaan')
                                        ->label('Nama Perusahaan')->columnSpanFull(),
                                    Forms\Components\TextInput::make('npwp')
                                        ->label('NPWP'),
                                    Forms\Components\FileUpload::make('npwp_file')
                                        ->label('NPWP File'),
                                    Forms\Components\TextInput::make('nib')
                                        ->label('NIB'),
                                    Forms\Components\FileUpload::make('nib_file')
                                        ->label('NIB File'),
                                    Forms\Components\TextArea::make('alamat')
                                        ->label('Alamat')->columnSpanFull(),
                                    Forms\Components\TextInput::make('provinsi')
                                        ->label('Provinsi'),
                                    Forms\Components\TextInput::make('domisili')
                                        ->label('Domisili'),
                                ]),
                        ]),
                    Wizard\Step::make('Unggah Berkas')
                        ->visible(fn (Get $get) => $get('checklist_berkas'))
                        ->schema([
                            Repeater::make('berkas')
                                ->schema(function (Get $get): array {
                                    $selectedOptions = collect($get('berkas.*.nama_persyaratan'))->filter();
                                    $currentMonthYear = Carbon::now()->format('Y-F');

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
                                            ->required()
                                            ->disableOptionWhen(function ($value, $state, Get $get) use ($selectedOptions) {
                                                return $selectedOptions->contains($value);
                                            })
                                            ->live()
                                            ->preload(),
                                        Forms\Components\FileUpload::make('file')
                                            ->required()
                                            ->openable()
                                            ->appendFiles()
                                            ->directory('berkas' . '/' . $currentMonthYear),
                                        Forms\Components\Select::make('status')
                                            ->visible('create', auth()->user()->roles->first()->name != 'pemohon')
                                            ->disabled(auth()->user()->roles->first()->name == 'pemohon')
                                            ->dehydrated()
                                            ->options([
                                                'Revision' => 'Revision',
                                                'Pending' => 'Pending',
                                                'Approved' => 'Approved',
                                                'Rejected' => 'Rejected',
                                            ])
                                            ->default('Pending')
                                            ->required(),
                                        Forms\Components\TextInput::make('keterangan')
                                            ->visible('create', auth()->user()->roles->first()->name != 'pemohon')
                                            ->disabled(auth()->user()->roles->first()->name == 'pemohon')
                                            ->dehydrated()
                                            ->default('-')
                                            ->required(),
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
                                    if (in_array('checklist_formulir', $option->features)) {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\TextInput::make('formulir.' . $option->nama_formulir);
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } else if ($option->type == 'date') {
                                    if (in_array('checklist_formulir', $option->features)) {
                                        $selectOptions[$option->nama_formulir] = Forms\Components\DatePicker::make('formulir.' . $option->nama_formulir);
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } else if ($option->type == 'select') {
                                    if (in_array('checklist_formulir', $option->features)) {
                                        $jsonOptions = $option->options;
                                        $valuesArray = array_map(function ($item) {
                                            return $item['value'];
                                        }, $jsonOptions);
                                        $selectOptions[$option->nama_formulir] = Forms\Components\Select::make('formulir.' . $option->nama_formulir)
                                            ->options(array_combine($valuesArray, $valuesArray));
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                }
                            }
                            return [
                                ...$selectOptions
                            ];
                        })->columns(2),
                    Wizard\Step::make('Back Office (Draft SK)')
                        ->visible(fn (Get $get) => $get('bo_after_opd_moderation'))
                        ->schema(function (Get $get): array {
                            $options = Formulir::whereIn('perizinan_id', function ($query) use ($get) {
                                $query->select('perizinan_id')
                                    ->from('formulirs')
                                    ->where('perizinan_id', $get('perizinan_id'));
                            })->get();

                            $selectOptions = [];
                            foreach ($options as $key => $option) {

                                if ($option->type == 'string') {
                                    if (in_array('bo_after_opd_moderation', $option->features)) {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\TextInput::make('formulir.' . $option->nama_formulir);
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } else if ($option->type == 'date') {
                                    if (in_array('bo_after_opd_moderation', $option->features)) {
                                        $selectOptions[$option->nama_formulir] = Forms\Components\DatePicker::make('formulir.' . $option->nama_formulir);
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } else if ($option->type == 'select') {
                                    if (in_array('bo_after_opd_moderation', $option->features)) {
                                        $jsonOptions = $option->options;
                                        $valuesArray = array_map(function ($item) {
                                            return $item['value'];
                                        }, $jsonOptions);
                                        $selectOptions[$option->nama_formulir] = Forms\Components\Select::make('formulir.' . $option->nama_formulir)
                                            ->options(array_combine($valuesArray, $valuesArray));
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                }
                            }
                            return [
                                ...$selectOptions
                            ];
                        })->columns(2),
                    Wizard\Step::make('Konfirmasi Permohonan')
                        ->schema([
                            Select::make('status_permohonan_id')
                                ->label('Status Permohonan')
                                ->searchable()
                                ->options(function (Get $get, $state) {
                                    $perizinan_lifecycle_id = Perizinan::where('id', $get('perizinan_id'))->pluck('perizinan_lifecycle_id')->first();
                                    $data = PerizinanLifecycle::where('id', $perizinan_lifecycle_id)
                                        ->pluck('flow_status');

                                    $options = [];
                                    foreach ($data as $item) {
                                        foreach ($item as $roleData) {
                                            if ($roleData['condition_status'] == $get('status_permohonan_id_from_edit') && $roleData['role'] == auth()->user()->roles->first()->id) {
                                                $options = $roleData['status'];
                                                break;
                                            } else if ($roleData['condition_status'] == null && $roleData['role'] == auth()->user()->roles->first()->id) {
                                                $options = $roleData['status'];
                                                break;
                                            }
                                        }
                                    }

                                    $final_relation_status = StatusPermohonan::whereIn('id', $options)->pluck('nama_status', 'id')->toArray();
                                    return $final_relation_status;
                                })
                                ->disabled(auth()->user()->roles->first()->name == 'pemohon')
                                ->dehydrated()
                                ->live(),
                            Hidden::make('nomor_rekomendasi'),
                            Hidden::make('nomor_izin'),
                            RichEditor::make('message')
                                ->visible(fn ($get) => $get('status_permohonan_id') === '2')
                                ->reactive(),
                            Placeholder::make('Apakah seluruh data yang diunggah sudah benar ?'),
                            Forms\Components\Checkbox::make('saya_setuju')
                                ->label('Ya, Saya Setuju!')
                                ->accepted(),
                        ])->live()
                        ->dehydrated()
                ])->columnSpanFull()->nextAction(
                    fn (Action $action) => $action->label('Selanjutnya'),
                )->previousAction(
                    fn (Action $action) => $action->label('Sebelumnya'),
                ),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('profile_usaha.nama_perusahaan')
                    ->label('Perusahaan/Perorangan')
                    ->default(fn ($record) => $record->profile_usaha->nama_perusahaan ?? fn ($record) => $record->user->name)
                    ->wrap()
                    ->sortable(),
                Tables\Columns\TextColumn::make('perizinan.nama_perizinan')
                    ->wrap()
                    ->words(5)
                    ->sortable(),
                Tables\Columns\TextColumn::make('perizinan.sektor.nama_sektor')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status_permohonan.general_status')
                    ->wrap()
                    ->lineClamp(2)
                    ->words(5)
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
            ->headerActions([
                ExportAction::make()
                    ->exporter(TrackingExporter::class)
            ])
            ->filters([
                SelectFilter::make('nama_sektor')
                    ->relationship('perizinan.sektor', 'nama_sektor')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('nama_perizinan')
                    ->relationship('perizinan', 'nama_perizinan')
                    ->searchable()
                    ->preload(),
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\Action::make('Unduh Izin')
                    ->icon('heroicon-s-arrow-down-circle')
                    ->url(fn (Permohonan $record): string => url('storage/' . $record->izin_terbit))
                    ->openUrlInNewTab()
                    ->visible(function ($record) {
                        return $record->status_permohonan_id == 11 && auth()->user()->roles->first()->name != 'opd_teknis';
                    }),
                Tables\Actions\Action::make('Lihat Pesan')
                    ->icon('heroicon-s-exclamation-triangle')
                    ->infolist([
                        \Filament\Infolists\Components\Section::make('Informasi')
                            ->schema([
                                TextEntry::make('message')
                                    ->html(),
                            ])
                            ->columns(),
                    ])
                    ->visible(function ($record) {
                        return $record->status_permohonan_id == 2;
                    }),
                Tables\Actions\Action::make('Tracking')
                    ->icon('heroicon-s-arrow-trending-up')
                    ->infolist([
                        \Filament\Infolists\Components\Section::make('Tracking Berkas')
                            ->schema([
                                RepeatableEntry::make('activity_log')
                                    ->schema([
                                        TextEntry::make('Activity'),
                                        TextEntry::make('Stake Holder'),
                                    ])
                                    ->columnSpanFull()
                            ])
                            ->columns(),
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    // public static function canViewAny(): bool
    // {
    //     return auth()->user()->roles->first()->name != 'pemohon';
    // }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }


    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $role = auth()->user()->roles->first()->id;
        $userId = auth()->id();

        $get_assign_perizinan_handle = AssignPerizinanHandle::where('user_id', $userId)->first();

        if (auth()->user()->roles->first()->name == 'pemohon') {
            return $query->where('user_id', $userId);
        } else if ($get_assign_perizinan_handle != null && $get_assign_perizinan_handle['is_all_perizinan'] == 0) {
            return $query->whereHas('status_permohonan', function ($query) use ($role, $get_assign_perizinan_handle) {
                $query->whereIn('perizinan_id', $get_assign_perizinan_handle['perizinan_id'])
                    ->whereJsonContains('role_id', "$role");
            });
        } elseif ($get_assign_perizinan_handle == null) {
            return $query;

        }
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTrackings::route('/'),
            'create' => Pages\CreateTracking::route('/create'),
            'view' => Pages\ViewTracking::route('/{record}'),
        ];
    }
}
