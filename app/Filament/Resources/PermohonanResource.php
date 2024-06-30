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
use Filament\Support\RawJs;
use Illuminate\Support\Str;
use App\Models\StatusPermohonan;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use App\Models\PerizinanLifecycle;
use Illuminate\Support\HtmlString;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Split;
use App\Models\AssignPerizinanHandle;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use App\Models\PerizinanConfiguration;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\ExportAction;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Wizard\Step;
use App\Filament\Exports\PermohonanExporter;
use Filament\Forms\Components\ToggleButtons;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Components\Actions\Action;
use Filament\Widgets\StatsOverviewWidget\Stat;
use NunoMaduro\Collision\Adapters\Phpunit\State;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PermohonanResource\Pages;
use App\Filament\Resources\PermohonanResource\RelationManagers;
use App\Filament\Resources\PermohonanResource\Pages\EditPermohonan;
use App\Filament\Resources\PermohonanResource\Pages\CreatePermohonan;

class PermohonanResource extends Resource
{
    protected static ?string $model = Permohonan::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-on-square-stack';
    protected static ?string $navigationGroup = 'Pengajuan';
    protected static ?string $pluralModelLabel = 'Permohonan';

    protected static ?int $navigationGroupSort = 1;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Wizard::make([
                    Wizard\Step::make('Pilih Perizinan')
                        ->schema([
                            Forms\Components\Select::make('perizinan_id')
                                ->relationship(
                                    name: 'perizinan',
                                    titleAttribute: 'nama_perizinan',
                                    modifyQueryUsing: function (Builder $query) {
                                        return $query->where('is_active', '1');
                                    }
                                )
                                ->searchable()
                                ->afterStateUpdated(function ($livewire, Set $set, Get $get, $state) {
                                    // $livewire->dispatch('refresh')->to(CreatePermohonan::class);
                                    $set('berkas.*.nama_persyaratan', '');
                                    $set('berkas.*.file', null);
                                    $perizinan = Perizinan::find($get('perizinan_id'));

                                    // Set False if not in the flow
                                    $possible_flows = Feature::all()->pluck('nama_feature')->toArray();
                                    foreach ($possible_flows as $flow_name) {
                                        $set($flow_name, false);
                                    }

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


                                    //Setting default choosing TTE/Manual

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
                                        //Setting default Nomor Izin && Nomor Rekomendasi
                                        $set('nomor_rekomendasi', $perizinan->perizinan_configuration->prefix_nomor_rekomendasi . $perizinan->perizinan_configuration->nomor_rekomendasi . $perizinan->perizinan_configuration->suffix_nomor_rekomendasi);
                                        $set('nomor_izin', $perizinan->perizinan_configuration->prefix_nomor_izin . $perizinan->perizinan_configuration->nomor_izin . $perizinan->perizinan_configuration->suffix_nomor_izin);
                                    }
                                })
                                ->required()
                                ->live()
                                ->disabledOn('edit')
                                ->dehydrated()
                                ->disableOptionWhen(fn (Get $get) => $get('perizinan_id') != null),
                        ]),
                    Wizard\Step::make('Unggah Berkas')
                        ->schema([
                            Section::make('List Persyaratan Yang Belum di Unggah')
                                ->schema(function (Get $get) {
                                    $selectedOptions = collect($get('berkas.*.nama_persyaratan'))->filter();
                                    $allOptions = Persyaratan::where('perizinan_id', $get('perizinan_id'))->pluck('nama_persyaratan', 'id');
                                    $unselectedOptions = $allOptions->filter(function ($value, $key) use ($selectedOptions) {
                                        return !$selectedOptions->contains($key);
                                    });

                                    // Mengubah $unselectedOptions menjadi string dalam format HTML <ol>
                                    $unselectedOptionsHtml = '<ol>';
                                    $counter = 1;
                                    foreach ($unselectedOptions as $option) {
                                        $unselectedOptionsHtml .= '<li>' . $counter . '. ' . htmlspecialchars($option, ENT_QUOTES, 'UTF-8') . '</li>';
                                        $counter++;
                                    }
                                    $unselectedOptionsHtml .= '</ol>';

                                    if ($unselectedOptions->isEmpty()) {
                                        $unselectedOptionsHtml = '<p>Semua berkas sudah lengkap diunggah</p>';
                                    }

                                    return [
                                        Placeholder::make('')
                                            ->content(new HtmlString($unselectedOptionsHtml)),
                                    ];
                                })->hidden(function (Get $get) {
                                    $selectedOptions = collect($get('berkas.*.nama_persyaratan'))->filter();
                                    $allOptions = Persyaratan::where('perizinan_id', $get('perizinan_id'))->pluck('nama_persyaratan', 'id');
                                    $unselectedOptions = $allOptions->filter(function ($value, $key) use ($selectedOptions) {
                                        return !$selectedOptions->contains($key);
                                    });

                                    if ($unselectedOptions->isEmpty()) {
                                        return true;
                                    }
                                })->live(),
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
                                            ->searchable()
                                            ->required()
                                            ->disableOptionWhen(function ($value, $state, Get $get) use ($selectedOptions) {
                                                return $selectedOptions->contains($value);
                                            })
                                            ->afterStateUpdated(function ($livewire, Set $set, Get $get, $state) {
                                                $persyaratan = Persyaratan::where('id', $get('nama_persyaratan'))->first();
                                                $set('deskripsi_persyaratan', $persyaratan->deskripsi_persyaratan ?? '-');
                                            })
                                            ->live()
                                            ->preload(),
                                        Forms\Components\Placeholder::make('deskripsi_persyaratan')
                                            ->content(function ($get) {
                                                $deskripsiPersyaratan = $get('deskripsi_persyaratan');
                                                return new HtmlString($deskripsiPersyaratan ?? '-');
                                            })
                                            ->default('-'),
                                        Forms\Components\FileUpload::make('file')
                                            ->deletable(auth()->user()->roles->first()->name == 'pemohon' ? true : false)
                                            ->dehydrated()
                                            ->required()
                                            ->appendFiles()
                                            ->directory('berkas' . '/' .  $currentMonthYear)
                                            ->appendFiles()
                                            ->columnSpanFull(),
                                        Forms\Components\Select::make('status')
                                            ->visible('create', auth()->user()->roles->first()->name != 'pemohon')
                                            ->disabled(auth()->user()->roles->first()->name == 'pemohon')
                                            ->hiddenOn('create')
                                            ->dehydrated()
                                            ->searchable()
                                            ->options([
                                                'Revision' => 'Revision',
                                                'Pending' => 'Pending',
                                                'Approved' => 'Approved',
                                                'Rejected' => 'Rejected',
                                            ])
                                            ->live()
                                            ->default('Pending')
                                            ->required(),
                                        Forms\Components\TextInput::make('keterangan')
                                            ->visible('create', auth()->user()->roles->first()->name != 'pemohon' && $get('status') == 'Rejected')
                                            ->disabled(auth()->user()->roles->first()->name == 'pemohon')
                                            ->hiddenOn('create')
                                            ->live()
                                            ->dehydrated()
                                            ->default('-')
                                            ->required(),
                                    ];
                                })
                                ->columns(2)
                                ->addActionLabel('Tambah Berkas')
                                ->extraItemActions([
                                    Action::make('Lihat Berkas')
                                        ->button('Lihat Berkas')
                                        ->icon('heroicon-m-cursor-arrow-ripple')
                                        ->url(function (array $arguments, Repeater $component): ?string {
                                            $itemData = $component->getItemState($arguments['item']) ?? '';
                                            if (!$itemData['file']) {
                                                return null;
                                            }

                                            return url('storage/' . $itemData['file']);
                                        }, shouldOpenInNewTab: true)
                                        ->hidden(fn (array $arguments, Repeater $component): bool => blank($component->getRawItemState($arguments['item'])['file'])),
                                ])
                                ->collapsed(auth()->user()->roles->first()->name != 'pemohon')
                                ->itemLabel(fn (array $state): ?string => ($state['status'] ?? 'Pending') . ' - ' . Persyaratan::where('id', $state['nama_persyaratan'] ?? null)->pluck('nama_persyaratan')->first())
                                ->deleteAction(
                                    fn (Action $action) => $action->requiresConfirmation(),
                                ),
                        ]),
                    Wizard\Step::make('Formulir')
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
                                        $input = Forms\Components\TextInput::make('formulir.' . $option->nama_formulir);

                                        if ($option->is_columnSpanFull == 1) {
                                            $input = $input->columnSpanFull(true);
                                        }

                                        $selectOptions[$option->nama_formulir] = $input;
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } elseif ($option->type == 'date') {
                                    if (in_array('checklist_formulir', $option->features)) {
                                        $input = Forms\Components\DatePicker::make('formulir.' . $option->nama_formulir);

                                        if ($option->is_columnSpanFull == 1) {
                                            $input = $input->columnSpanFull(true);
                                        }

                                        $selectOptions[$option->nama_formulir] = $input;
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } elseif ($option->type == 'select') {
                                    if (in_array('checklist_formulir', $option->features)) {
                                        $jsonOptions = $option->options;
                                        $valuesArray = array_map(function ($item) {
                                            return $item['value'];
                                        }, $jsonOptions);

                                        $input = Forms\Components\Select::make('formulir.' . $option->nama_formulir)
                                            ->options(array_combine($valuesArray, $valuesArray));

                                        if ($option->is_columnSpanFull == 1) {
                                            $input = $input->columnSpanFull(true);
                                        }

                                        $selectOptions[$option->nama_formulir] = $input;
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } elseif ($option->type == 'textarea') { // Add this block for textarea
                                    if (in_array('checklist_formulir', $option->features)) {
                                        $input = Forms\Components\Textarea::make('formulir.' . $option->nama_formulir);

                                        if ($option->is_columnSpanFull == 1) {
                                            $input = $input->columnSpanFull(true);
                                        }

                                        $selectOptions[$option->nama_formulir] = $input;
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } elseif ($option->type == 'richeditor') { // Add this block for richeditor
                                    if (in_array('checklist_formulir', $option->features)) {
                                        $input = Forms\Components\RichEditor::make('formulir.' . $option->nama_formulir)
                                            ->toolbarButtons([
                                                'orderedList',
                                            ]);

                                        if ($option->is_columnSpanFull == 1) {
                                            $input = $input->columnSpanFull(true);
                                        }

                                        $selectOptions[$option->nama_formulir] = $input;
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
                                        ->openable()
                                        ->label('NPWP File'),
                                    Forms\Components\TextInput::make('nib')
                                        ->label('NIB'),
                                    Forms\Components\FileUpload::make('nib_file')
                                        ->openable()
                                        ->label('NIB File'),
                                    Forms\Components\Textarea::make('alamat')
                                        ->label('Alamat')->columnSpanFull(),
                                    Forms\Components\Select::make('provinsi')
                                        ->options([
                                            'Kepulauan Riau' => 'Kepulauan Riau',
                                        ])
                                        ->native(false)
                                        ->label('Provinsi'),
                                    Forms\Components\Select::make('domisili')
                                        ->options([
                                            'Kabupaten Bintan' => 'Kabupaten Bintan',
                                            'Kabupaten Karimun' => 'Kabupaten Karimun',
                                            'Kabupaten Kepulauan Anambas' => 'Kabupaten Kepulauan Anambas',
                                            'Kabupaten Lingga' => 'Kabupaten Lingga',
                                            'Kabupaten Natuna' => 'Kabupaten Natuna',
                                            'Kota Batam' => 'Kota Tanjungpinang',
                                        ])
                                        ->native(false)
                                        ->label('Domisili'),
                                ]),
                        ]),
                    Wizard\Step::make('Back Office')
                        ->description('Permintaan Rekomendasi')
                        ->visible(fn (Get $get) => $get('bo_before_opd_moderation'))
                        ->schema(function (Get $get): array {
                            $options = Formulir::whereIn('perizinan_id', function ($query) use ($get) {
                                $query->select('perizinan_id')
                                    ->from('formulirs')
                                    ->where('perizinan_id', $get('perizinan_id'));
                            })->get();

                            $selectOptions = [];
                            foreach ($options as $key => $option) {

                                if ($option->type == 'string') {
                                    if (in_array('bo_before_opd_moderation', $option->features)) {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\TextInput::make('formulir.' . $option->nama_formulir);
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } else if ($option->type == 'date') {
                                    if (in_array('bo_before_opd_moderation', $option->features)) {
                                        $selectOptions[$option->nama_formulir] = Forms\Components\DatePicker::make('formulir.' . $option->nama_formulir);
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } else if ($option->type == 'select') {
                                    if (in_array('bo_before_opd_moderation', $option->features)) {
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

                                Forms\Components\TextInput::make('nomor_rekomendasi')
                                    ->label('Nomor Surat Permintaan Rekomendasi'),

                                ...$selectOptions,

                                ToggleButtons::make('tanda_tangan_permintaan_rekomendasi')
                                    ->label('Konfigurasi Izin')
                                    ->options([
                                        'is_template_rekomendasi' => 'Menggunakan Template Rekomendasi',
                                        'is_manual_rekomendasi' => 'Unggah Manual Rekomendasi',
                                    ])
                                    ->default(fn ($get) => Perizinan::where('id', $get('perizinan_id'))->pluck('is_save_as_template_rekomendasi')->first() == 1 ? 'is_template_rekomendasi' : 'is_manual_rekomendasi')
                                    ->live()
                                    ->inline()
                                    ->columnSpanFull()
                                    ->afterStateUpdated(function ($livewire, Set $set, Get $get, $state) {
                                        if ($get('tanda_tangan_permintaan_rekomendasi') == 'is_template_rekomendasi') {
                                            $perizinan = Perizinan::where('id', $get('perizinan_id'))->pluck('is_save_as_template_rekomendasi')->first();
                                            if ($perizinan != 1) {
                                                $set('tanda_tangan_permintaan_rekomendasi', 'is_manual_rekomendasi');
                                                Notification::make()
                                                    ->title('Fitur ini masih dalam pengembangan')
                                                    ->warning()
                                                    ->duration(5000)
                                                    ->send();
                                            }
                                        }
                                    }),
                                Forms\Components\FileUpload::make('rekomendasi_terbit')
                                    ->required()
                                    ->columnSpanFull()
                                    ->openable()
                                    ->directory('rekomendasi_terbit' . '/' . Carbon::now()->format('Y-F'))
                                    ->hidden(fn ($get) => $get('tanda_tangan_permintaan_rekomendasi') !== 'is_manual_rekomendasi')
                            ];
                        })->columns(2),
                    Wizard\Step::make('Kadis Tanda Tangan')
                        ->description('Permintaan Rekomendasi')
                        ->visible(fn (Get $get) => $get('kadis_before_opd_moderation'))
                        ->schema(function (Get $get): array {
                            $options = Formulir::whereIn('perizinan_id', function ($query) use ($get) {
                                $query->select('perizinan_id')
                                    ->from('formulirs')
                                    ->where('perizinan_id', $get('perizinan_id'));
                            })->get();

                            $selectOptions = [];
                            foreach ($options as $key => $option) {

                                if ($option->type == 'string') {
                                    if (in_array('bo_before_opd_moderation', $option->features)) {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\TextInput::make('formulir.' . $option->nama_formulir);
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } else if ($option->type == 'date') {
                                    if (in_array('bo_before_opd_moderation', $option->features)) {
                                        $selectOptions[$option->nama_formulir] = Forms\Components\DatePicker::make('formulir.' . $option->nama_formulir);
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } else if ($option->type == 'select') {
                                    if (in_array('bo_before_opd_moderation', $option->features)) {
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

                                Forms\Components\TextInput::make('nomor_rekomendasi')
                                    ->label('Nomor Surat Rekomendasi'),

                                ...$selectOptions,

                                ToggleButtons::make('tanda_tangan_permintaan_rekomendasi')
                                    ->label('Konfigurasi Tanda Tangan')
                                    ->options([
                                        'is_template_rekomendasi' => 'TTE dari Template Rekomendasi',
                                        'is_manual_rekomendasi' => 'Unggah Manual Rekomendasi',
                                    ])
                                    ->live()
                                    ->inline()
                                    ->columnSpanFull()
                                    ->afterStateUpdated(function ($livewire, Set $set, Get $get, $state) {
                                        if ($get('tanda_tangan_permintaan_rekomendasi') == 'is_template_rekomendasi') {
                                            $perizinan = Perizinan::where('id', $get('perizinan_id'))->pluck('is_save_as_template_rekomendasi')->first();
                                            if ($perizinan != 1) {
                                                $set('tanda_tangan_permintaan_rekomendasi', 'is_manual_rekomendasi');
                                                Notification::make()
                                                    ->title('Fitur ini masih dalam pengembangan')
                                                    ->warning()
                                                    ->duration(5000)
                                                    ->send();
                                            }
                                        }
                                    }),
                                Forms\Components\FileUpload::make('rekomendasi_terbit')
                                    ->required()
                                    ->columnSpanFull()
                                    ->openable()
                                    ->directory('rekomendasi_terbit' . '/' . Carbon::now()->format('Y-F'))
                                    ->hidden(fn ($get) => $get('tanda_tangan_permintaan_rekomendasi') !== 'is_manual_rekomendasi')
                            ];
                        })->columns(2),
                    Wizard\Step::make('OPD')
                        ->description('Melakukan Kajian Teknis')
                        ->visible(fn (Get $get) => $get('opd_moderation'))
                        ->schema([
                            Forms\Components\TextInput::make('nomor_kajian_teknis')
                                ->label('Nomor Surat Kajian Teknis'),
                            Forms\Components\DatePicker::make('tanggal_kajian_teknis_terbit')
                                ->label('Tanggal Surat Kajian Teknis'),
                            Forms\Components\FileUpload::make('kajian_teknis')
                                ->openable()
                                ->label('Rekomendasi Teknis')
                                ->directory('kajian_teknis')
                                ->openable()
                                ->columnSpanFull(),
                        ])->columns(2),
                    Wizard\Step::make('Back Office')
                        ->description('Membuat Draft Izin')
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

                                Forms\Components\TextInput::make('nomor_izin')
                                    ->label('Nomor Surat Izin'),

                                Forms\Components\DatePicker::make('tanggal_izin_terbit')
                                    ->label('Tanggal Izin Terbit'),


                                ...$selectOptions,
                                ToggleButtons::make('tanda_tangan_izin')
                                    ->label('Konfigurasi Izin')
                                    ->options([
                                        'is_template_izin' => 'Menggunakan Template Izin',
                                        'is_manual_izin' => 'Unggah Manual Izin',
                                    ])
                                    ->default(fn ($get) => Perizinan::where('id', $get('perizinan_id'))->pluck('is_save_as_template_izin')->first() == 1 ? 'is_template_izin' : 'is_manual_izin')
                                    ->live()
                                    ->inline()
                                    ->afterStateUpdated(function ($livewire, Set $set, Get $get, $state) {
                                        if ($get('tanda_tangan_izin') == 'is_template_izin') {
                                            $perizinan = Perizinan::where('id', $get('perizinan_id'))->pluck('is_save_as_template_izin')->first();
                                            if ($perizinan != 1) {
                                                $set('tanda_tangan_izin', 'is_manual_izin');
                                                Notification::make()
                                                    ->title('Fitur ini masih dalam pengembangan')
                                                    ->warning()
                                                    ->duration(5000)
                                                    ->send();
                                            }
                                        }
                                    }),
                                Forms\Components\FileUpload::make('izin_terbit')
                                    ->required()
                                    ->openable()
                                    ->columnSpanFull()
                                    ->directory('izin_terbit' . '/' . Carbon::now()->format('Y-F'))
                                    ->hidden(fn ($get) => $get('tanda_tangan_izin') !== 'is_manual_izin')
                            ];
                        })->columns(2),

                    Wizard\Step::make('Kadis Tanda Tangan')
                        ->description('Izin Terbit')
                        ->visible(fn (Get $get) => $get('kadis_after_opd_moderation'))
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

                                Forms\Components\TextInput::make('nomor_izin')
                                    ->label('Nomor Surat Izin'),

                                Forms\Components\DatePicker::make('tanggal_izin_terbit')
                                    ->label('Tanggal Izin Terbit'),


                                ...$selectOptions,
                                ToggleButtons::make('tanda_tangan_izin')
                                    ->label('Konfigurasi Izin')
                                    ->options([
                                        'is_template_izin' => 'TTE dari Template Izin',
                                        'is_manual_izin' => 'Unggah Manual Izin',
                                    ])
                                    ->gridDirection('row')
                                    ->live()
                                    ->inline()
                                    ->afterStateUpdated(function ($livewire, Set $set, Get $get, $state) {
                                        if ($get('tanda_tangan_izin') == 'is_template_izin') {
                                            $perizinan = Perizinan::where('id', $get('perizinan_id'))->pluck('is_save_as_template_izin')->first();
                                            if ($perizinan != 1) {
                                                $set('tanda_tangan_izin', 'is_manual_izin');
                                                Notification::make()
                                                    ->title('Fitur ini masih dalam pengembangan')
                                                    ->warning()
                                                    ->duration(5000)
                                                    ->send();
                                            }
                                        }
                                    }),
                                Forms\Components\FileUpload::make('izin_terbit')
                                    ->required()
                                    ->openable()
                                    ->columnSpanFull()
                                    ->directory('izin_terbit' . '/' . Carbon::now()->format('Y-F'))
                                    ->hidden(fn ($get) => $get('tanda_tangan_izin') !== 'is_manual_izin')
                            ];
                        })->columns(2),

                    Wizard\Step::make('Konfirmasi Permohonan')
                        ->visible(fn (Get $get) => $get('konfirmasi_permohonan'))
                        ->schema([
                            Select::make('status_permohonan_id')
                                ->label('Status Permohonan')
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
                                ->searchable()
                                ->disabled(auth()->user()->roles->first()->name == 'pemohon')
                                ->live()
                                ->dehydrated(),
                            RichEditor::make('message')
                                ->visible(fn ($get) => $get('status_permohonan_id') === '2'),
                            RichEditor::make('message_bo')
                                ->label('Permintaan Perbaikan Berkas Ke Back Office')
                                ->visible(fn ($get) => ($get('status_permohonan_id') === '4' || $get('status_permohonan_id') === '8') && auth()->user()->roles->first()->name == 'verifikator'),
                            Placeholder::make('Apakah seluruh data yang diunggah sudah benar ?'),
                            // Forms\Components\Checkbox::make('saya_setuju')
                            //     ->label('Ya, Saya Setuju!')
                            //     ->accepted(),
                            Hidden::make('nomor_rekomendasi'),
                            Hidden::make('nomor_izin'),
                        ]),
                ])->columnSpanFull()->nextAction(
                    fn (Action $action) => $action->label('Selanjutnya'),
                )->previousAction(
                    fn (Action $action) => $action->label('Sebelumnya'),
                )->skippable(),
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
            ->headerActions([])
            ->filters([
                //
            ])
            ->actions([
                // Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->visible(fn ($record) => auth()->user()->roles->first()->name == 'pemohon' && $record->status_permohonan_id == 2 || auth()->user()->roles->first()->name != 'pemohon')
                    ->label('Tinjau'),
                Tables\Actions\Action::make('Unduh Izin')
                    ->icon('heroicon-s-arrow-down-circle')
                    // ->url(fn (Permohonan $record): string => url('storage/izin/' . $record->izin_terbit))
                    ->url(fn (Permohonan $record): string => url('storage/' . $record->izin_terbit))
                    ->openUrlInNewTab()
                    ->visible(function ($record) {
                        return $record->status_permohonan_id == 11;
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
                Tables\Actions\Action::make('Perbaikan Draft')
                    ->icon('heroicon-s-exclamation-triangle')
                    ->infolist([
                        \Filament\Infolists\Components\Section::make('Informasi')
                            ->schema([
                                TextEntry::make('message_bo')
                                    ->html(),
                            ])
                            ->columns(),
                    ])
                    ->visible(function ($record) {
                        return ($record->status_permohonan_id == 4 || $record->status_permohonan_id == 8) && $record->message_bo != null && auth()->user()->roles->first()->name == 'back_office';
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->visible(function () {
                            return auth()->user()->roles->first()->name == 'super_admin';
                        }),
                ]),
            ]);
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
            return $query->whereHas('status_permohonan', function ($query) use ($role) {
                $query->whereJsonContains('role_id', "$role");
            });
        } elseif ($get_assign_perizinan_handle['is_all_perizinan'] == 1) {
            return $query->whereHas('status_permohonan', function ($query) use ($role) {
                $query->whereJsonContains('role_id', "$role");
            });
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
            'draft' => Pages\DraftIzin::route('/{record}/draft'),
        ];
    }
}
