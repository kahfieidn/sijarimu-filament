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
use Illuminate\Support\HtmlString;
use Filament\Tables\Filters\Filter;
use Illuminate\Contracts\View\View;
use App\Models\AssignPerizinanHandle;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Repeater;
use Filament\Notifications\Notification;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Exports\TrackingExporter;
use Filament\Forms\Components\Placeholder;
use Custom\Path\Models\Permohonan\Tracking;
use Filament\Forms\Components\ToggleButtons;
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
    protected static ?int $navigationSort = 2;

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
                                ->preload()
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
                                            ->hint('File harus berformat PDF dan Maximal 2MB')
                                            ->appendFiles()
                                            ->acceptedFileTypes(['application/pdf'])
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
                                    Action::make('Lihat')
                                        ->button('Lihat')
                                        ->modalContent(function (array $arguments, Repeater $component): View {
                                            $itemData = $component->getItemState($arguments['item']) ?? '';

                                            if (blank($itemData['file'])) {
                                                abort(404, 'File not found');
                                            }

                                            $nama_persyaratan = Persyaratan::where('id', $itemData['nama_persyaratan'])->pluck('nama_persyaratan')->first();

                                            return view('filament.pages.actions.berkas', [
                                                'nama_persyaratan' => $nama_persyaratan,
                                                'fileUrl' => url('storage/' . $itemData['file']),
                                            ]);
                                        })
                                        ->modalSubmitAction(false)
                                        ->modalCancelActionLabel('Tutup')
                                        ->hidden(fn (array $arguments, Repeater $component): bool => blank($component->getRawItemState($arguments['item'])['file'])),
                                    Action::make('Approved')
                                        ->button('')
                                        ->label('✓')
                                        ->action(function (array $arguments, Set $set, Get $get, Repeater $component) {
                                            $set('berkas.' . $arguments['item'] . '.status', 'Approved');
                                        })
                                        ->color('success')
                                        ->disabled(fn (array $arguments, Repeater $component): bool => $component->getRawItemState($arguments['item'])['status'] == 'Approved')
                                        ->visible(auth()->user()->roles->first()->name != 'pemohon' ? true : false),
                                    Action::make('Revision')
                                        ->button('')
                                        ->label('✘')
                                        ->action(function (array $arguments, Set $set, Get $get, Repeater $component) {
                                            $set('berkas.' . $arguments['item'] . '.status', 'Revision');
                                        })
                                        ->color('danger')
                                        ->disabled(fn (array $arguments, Repeater $component): bool => $component->getRawItemState($arguments['item'])['status'] == 'Revision')
                                        ->visible(auth()->user()->roles->first()->name != 'pemohon' ? true : false),
                                ])
                                ->collapsed(auth()->user()->roles->first()->name != 'pemohon')
                                ->itemLabel(fn (array $state): ?string => ($state['status'] ?? 'Pending') . ' - ' . Persyaratan::where('id', $state['nama_persyaratan'] ?? null)->pluck('nama_persyaratan')->first())
                                ->deleteAction(
                                    fn (Action $action) => $action->requiresConfirmation(),
                                )
                                ->deletable(auth()->user()->roles->first()->name == 'pemohon' ? true : false),
                            Toggle::make('is_catatan_kesimpulan')
                                ->visible(auth()->user()->roles->first()->name != 'pemohon')
                                ->label('Apakah ada catatan kesimpulan?')
                                ->live(),
                            RichEditor::make('catatan_kesimpulan')
                                ->dehydrated(true)
                                ->hidden(fn (Get $get): bool => !$get('is_catatan_kesimpulan') || $get('is_catatan_kesimpulan') == null)
                        ]),
                    Wizard\Step::make('Formulir')
                        ->visible(fn (Get $get) => $get('checklist_formulir'))
                        ->schema(function (Get $get): array {
                            $options = Formulir::whereIn('perizinan_id', function ($query) use ($get) {
                                $query->select('perizinan_id')
                                    ->from('formulirs')
                                    ->where('perizinan_id', $get('perizinan_id'));
                            })->get();

                            // List Formulir
                            $selectOptions = [];
                            foreach ($options as $key => $option) {
                                if ($option->type == 'string') {
                                    if (in_array('checklist_formulir', $option->features)) {
                                        $input = Forms\Components\TextInput::make('formulir.' . $option->nama_formulir)
                                            ->helperText(new HtmlString($option->helper_text))
                                            ->required();
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
                                        $input = Forms\Components\DatePicker::make('formulir.' . $option->nama_formulir)
                                            ->helperText(new HtmlString($option->helper_text))
                                            ->required();
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
                                            ->helperText(new HtmlString($option->helper_text))
                                            ->options(array_combine($valuesArray, $valuesArray))
                                            ->required();
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
                                        $input = Forms\Components\Textarea::make('formulir.' . $option->nama_formulir)
                                            ->helperText(new HtmlString($option->helper_text))
                                            ->required();
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
                                            ])
                                            ->helperText(new HtmlString($option->helper_text))
                                            ->required();
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
                                        ->required()
                                        ->label('Nama Perusahaan')->columnSpanFull(),
                                    Forms\Components\TextInput::make('npwp')
                                        ->required()
                                        ->label('NPWP'),
                                    Forms\Components\FileUpload::make('npwp_file')
                                        ->required()
                                        ->openable()
                                        ->label('NPWP File'),
                                    Forms\Components\TextInput::make('nib')
                                        ->required()
                                        ->label('NIB'),
                                    Forms\Components\FileUpload::make('nib_file')
                                        ->required()
                                        ->openable()
                                        ->label('NIB File'),
                                    Forms\Components\Textarea::make('alamat')
                                        ->required()
                                        ->label('Alamat')->columnSpanFull(),
                                    Forms\Components\Select::make('provinsi')
                                        ->options([
                                            'Kepulauan Riau' => 'Kepulauan Riau',
                                        ])
                                        ->native(false)
                                        ->required()
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
                                        ->required()
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
                            $final_relation_status_id = $get('final_relation_status_id') ?? [];
                            foreach ($options as $key => $option) {
                                if ($option->type == 'string') {
                                    if (in_array('bo_before_opd_moderation', $option->features)) {
                                        $input = Forms\Components\TextInput::make('formulir.' . $option->nama_formulir)
                                            ->helperText(new HtmlString($option->helper_text))
                                            ->required($get('status_permohonan_id') == end($final_relation_status_id) ?? true);
                                        if ($option->is_columnSpanFull == 1) {
                                            $input = $input->columnSpanFull(true);
                                        }

                                        $selectOptions[$option->nama_formulir] = $input;
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } elseif ($option->type == 'date') {
                                    if (in_array('bo_before_opd_moderation', $option->features)) {
                                        $input = Forms\Components\DatePicker::make('formulir.' . $option->nama_formulir)
                                            ->helperText(new HtmlString($option->helper_text))
                                            ->required($get('status_permohonan_id') == end($final_relation_status_id) ?? true);
                                        if ($option->is_columnSpanFull == 1) {
                                            $input = $input->columnSpanFull(true);
                                        }

                                        $selectOptions[$option->nama_formulir] = $input;
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } elseif ($option->type == 'select') {
                                    if (in_array('bo_before_opd_moderation', $option->features)) {
                                        $jsonOptions = $option->options;
                                        $valuesArray = array_map(function ($item) {
                                            return $item['value'];
                                        }, $jsonOptions);

                                        $input = Forms\Components\Select::make('formulir.' . $option->nama_formulir)
                                            ->helperText(new HtmlString($option->helper_text))
                                            ->options(array_combine($valuesArray, $valuesArray))
                                            ->required($get('status_permohonan_id') == end($final_relation_status_id) ?? true);
                                        if ($option->is_columnSpanFull == 1) {
                                            $input = $input->columnSpanFull(true);
                                        }

                                        $selectOptions[$option->nama_formulir] = $input;
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } elseif ($option->type == 'textarea') { // Add this block for textarea
                                    if (in_array('bo_before_opd_moderation', $option->features)) {
                                        $input = Forms\Components\Textarea::make('formulir.' . $option->nama_formulir)
                                            ->helperText(new HtmlString($option->helper_text))
                                            ->required($get('status_permohonan_id') == end($final_relation_status_id) ?? true);
                                        if ($option->is_columnSpanFull == 1) {
                                            $input = $input->columnSpanFull(true);
                                        }

                                        $selectOptions[$option->nama_formulir] = $input;
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } elseif ($option->type == 'richeditor') { // Add this block for richeditor
                                    if (in_array('bo_before_opd_moderation', $option->features)) {
                                        $input = Forms\Components\RichEditor::make('formulir.' . $option->nama_formulir)
                                            ->toolbarButtons([
                                                'orderedList',
                                            ])
                                            ->helperText(new HtmlString($option->helper_text))
                                            ->required($get('status_permohonan_id') == end($final_relation_status_id) ?? true);
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
                                Forms\Components\TextInput::make('nomor_rekomendasi')
                                    ->label('Nomor Surat Permintaan Rekomendasi')
                                    ->required(),
                                Forms\Components\DatePicker::make('tanggal_rekomendasi_terbit')
                                    ->readOnly()
                                    ->required()
                                    ->label('Tanggal Permintaan Rekomendasi'),
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
                                    ->required($get('status_permohonan_id') == end($final_relation_status_id) ?? true)
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
                            $final_relation_status_id = $get('final_relation_status_id') ?? [];
                            foreach ($options as $key => $option) {
                                if ($option->type == 'string') {
                                    if (in_array('kadis_before_opd_moderation', $option->features)) {
                                        $input = Forms\Components\TextInput::make('formulir.' . $option->nama_formulir)
                                            ->helperText(new HtmlString($option->helper_text))
                                            ->required($get('status_permohonan_id') == end($final_relation_status_id) ?? true);
                                        if ($option->is_columnSpanFull == 1) {
                                            $input = $input->columnSpanFull(true);
                                        }

                                        $selectOptions[$option->nama_formulir] = $input;
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } elseif ($option->type == 'date') {
                                    if (in_array('kadis_before_opd_moderation', $option->features)) {
                                        $input = Forms\Components\DatePicker::make('formulir.' . $option->nama_formulir)
                                            ->helperText(new HtmlString($option->helper_text))
                                            ->required($get('status_permohonan_id') == end($final_relation_status_id) ?? true);
                                        if ($option->is_columnSpanFull == 1) {
                                            $input = $input->columnSpanFull(true);
                                        }

                                        $selectOptions[$option->nama_formulir] = $input;
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } elseif ($option->type == 'select') {
                                    if (in_array('kadis_before_opd_moderation', $option->features)) {
                                        $jsonOptions = $option->options;
                                        $valuesArray = array_map(function ($item) {
                                            return $item['value'];
                                        }, $jsonOptions);

                                        $input = Forms\Components\Select::make('formulir.' . $option->nama_formulir)
                                            ->helperText(new HtmlString($option->helper_text))
                                            ->options(array_combine($valuesArray, $valuesArray))
                                            ->required($get('status_permohonan_id') == end($final_relation_status_id) ?? true);
                                        if ($option->is_columnSpanFull == 1) {
                                            $input = $input->columnSpanFull(true);
                                        }

                                        $selectOptions[$option->nama_formulir] = $input;
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } elseif ($option->type == 'textarea') { // Add this block for textarea
                                    if (in_array('kadis_before_opd_moderation', $option->features)) {
                                        $input = Forms\Components\Textarea::make('formulir.' . $option->nama_formulir)
                                            ->helperText(new HtmlString($option->helper_text))
                                            ->required($get('status_permohonan_id') == end($final_relation_status_id) ?? true);
                                        if ($option->is_columnSpanFull == 1) {
                                            $input = $input->columnSpanFull(true);
                                        }

                                        $selectOptions[$option->nama_formulir] = $input;
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } elseif ($option->type == 'richeditor') { // Add this block for richeditor
                                    if (in_array('kadis_before_opd_moderation', $option->features)) {
                                        $input = Forms\Components\RichEditor::make('formulir.' . $option->nama_formulir)
                                            ->toolbarButtons([
                                                'orderedList',
                                            ])
                                            ->helperText(new HtmlString($option->helper_text))
                                            ->required($get('status_permohonan_id') == end($final_relation_status_id) ?? true);
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

                                Forms\Components\TextInput::make('nomor_rekomendasi')
                                    ->required()
                                    ->label('Nomor Surat Rekomendasi'),
                                Forms\Components\DatePicker::make('tanggal_rekomendasi_terbit')
                                    ->readOnly()
                                    ->required()
                                    ->label('Tanggal Permintaan Rekomendasi'),

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
                                    ->required($get('status_permohonan_id') == end($final_relation_status_id) ?? true)
                                    ->columnSpanFull()
                                    ->openable()
                                    ->directory('rekomendasi_terbit' . '/' . Carbon::now()->format('Y-F'))
                                    ->hidden(fn ($get) => $get('tanda_tangan_permintaan_rekomendasi') !== 'is_manual_rekomendasi')
                            ];
                        })->columns(2),
                    Wizard\Step::make('OPD')
                        ->description('Melakukan Kajian Teknis')
                        ->visible(fn (Get $get) => $get('opd_moderation'))
                        ->schema(function (Get $get) {
                            $final_relation_status_id = $get('final_relation_status_id') ?? [];

                            return [
                                Forms\Components\TextInput::make('nomor_kajian_teknis')
                                    ->required($get('status_permohonan_id') == end($final_relation_status_id) ?? true)
                                    ->label('Nomor Surat Kajian Teknis'),
                                Forms\Components\DatePicker::make('tanggal_kajian_teknis_terbit')
                                    ->required($get('status_permohonan_id') == end($final_relation_status_id) ?? true)
                                    ->label('Tanggal Surat Kajian Teknis'),
                                Forms\Components\FileUpload::make('kajian_teknis')
                                    ->required($get('status_permohonan_id') == end($final_relation_status_id) ?? true)
                                    ->openable()
                                    ->label('Rekomendasi Teknis')
                                    ->directory('kajian_teknis')
                                    ->openable()
                                    ->columnSpanFull(),
                            ];
                        })->columns(2),
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
                            $final_relation_status_id = $get('final_relation_status_id') ?? [];
                            foreach ($options as $key => $option) {

                                if ($option->type == 'string') {
                                    if (in_array('bo_after_opd_moderation', $option->features)) {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\TextInput::make('formulir.' . $option->nama_formulir)
                                            ->required($get('status_permohonan_id') == end($final_relation_status_id) ?? true);
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } else if ($option->type == 'date') {
                                    if (in_array('bo_after_opd_moderation', $option->features)) {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\DatePicker::make('formulir.' . $option->nama_formulir)
                                            ->required($get('status_permohonan_id') == end($final_relation_status_id) ?? true);
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
                                            ->required($get('status_permohonan_id') == end($final_relation_status_id) ?? true)
                                            ->options(array_combine($valuesArray, $valuesArray));
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                }
                            }
                            return [

                                Forms\Components\TextInput::make('nomor_izin')
                                    ->required()
                                    ->label('Nomor Surat Izin'),

                                Forms\Components\DatePicker::make('tanggal_izin_terbit')
                                    ->required()
                                    ->readOnly()
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
                                    ->required($get('status_permohonan_id') == end($final_relation_status_id) ?? true)
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
                            $final_relation_status_id = $get('final_relation_status_id') ?? [];
                            foreach ($options as $key => $option) {
                                if ($option->type == 'string') {
                                    if (in_array('kadis_after_opd_moderation', $option->features)) {
                                        $input = Forms\Components\TextInput::make('formulir.' . $option->nama_formulir)
                                            ->helperText(new HtmlString($option->helper_text))
                                            ->required($get('status_permohonan_id') == end($final_relation_status_id) ?? true);
                                        if ($option->is_columnSpanFull == 1) {
                                            $input = $input->columnSpanFull(true);
                                        }

                                        $selectOptions[$option->nama_formulir] = $input;
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } elseif ($option->type == 'date') {
                                    if (in_array('kadis_after_opd_moderation', $option->features)) {
                                        $input = Forms\Components\DatePicker::make('formulir.' . $option->nama_formulir)
                                            ->helperText(new HtmlString($option->helper_text))
                                            ->required($get('status_permohonan_id') == end($final_relation_status_id) ?? true);
                                        if ($option->is_columnSpanFull == 1) {
                                            $input = $input->columnSpanFull(true);
                                        }

                                        $selectOptions[$option->nama_formulir] = $input;
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } elseif ($option->type == 'select') {
                                    if (in_array('kadis_after_opd_moderation', $option->features)) {
                                        $jsonOptions = $option->options;
                                        $valuesArray = array_map(function ($item) {
                                            return $item['value'];
                                        }, $jsonOptions);

                                        $input = Forms\Components\Select::make('formulir.' . $option->nama_formulir)
                                            ->helperText(new HtmlString($option->helper_text))
                                            ->options(array_combine($valuesArray, $valuesArray))
                                            ->required($get('status_permohonan_id') == end($final_relation_status_id) ?? true);
                                        if ($option->is_columnSpanFull == 1) {
                                            $input = $input->columnSpanFull(true);
                                        }

                                        $selectOptions[$option->nama_formulir] = $input;
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } elseif ($option->type == 'textarea') { // Add this block for textarea
                                    if (in_array('kadis_after_opd_moderation', $option->features)) {
                                        $input = Forms\Components\Textarea::make('formulir.' . $option->nama_formulir)
                                            ->helperText(new HtmlString($option->helper_text))
                                            ->required($get('status_permohonan_id') == end($final_relation_status_id) ?? true);
                                        if ($option->is_columnSpanFull == 1) {
                                            $input = $input->columnSpanFull(true);
                                        }

                                        $selectOptions[$option->nama_formulir] = $input;
                                    } else {
                                        $selectOptions[$option->nama_formulir] =
                                            Forms\Components\Hidden::make('formulir.' . $option->nama_formulir);
                                    }
                                } elseif ($option->type == 'richeditor') { // Add this block for richeditor
                                    if (in_array('kadis_after_opd_moderation', $option->features)) {
                                        $input = Forms\Components\RichEditor::make('formulir.' . $option->nama_formulir)
                                            ->toolbarButtons([
                                                'orderedList',
                                            ])
                                            ->helperText(new HtmlString($option->helper_text))
                                            ->required($get('status_permohonan_id') == end($final_relation_status_id) ?? true);
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

                                Forms\Components\TextInput::make('nomor_izin')
                                    ->required()
                                    ->label('Nomor Surat Izin'),

                                Forms\Components\DatePicker::make('tanggal_izin_terbit')
                                    ->required()
                                    ->readOnly()
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
                                    ->required($get('status_permohonan_id') == end($final_relation_status_id) ?? true)
                                    ->openable()
                                    ->columnSpanFull()
                                    ->directory('izin_terbit' . '/' . Carbon::now()->format('Y-F'))
                                    ->hidden(fn ($get) => $get('tanda_tangan_izin') !== 'is_manual_izin')
                            ];
                        })->columns(2),

                    Wizard\Step::make('Konfirmasi Permohonan')
                        ->schema([
                            Select::make('status_permohonan_id')
                                ->label('Status Permohonan')
                                ->options(function (Get $get, $state, string $operation) {
                                    if ($operation === 'create') {
                                        // Get Status Permohonan ID from Edit Permohonan
                                        $perizinan_lifecycle_id = Perizinan::where('id', $get('perizinan_id'))->pluck('perizinan_lifecycle_id')->first();
                                        $data_lifecycle = PerizinanLifecycle::where('id', $perizinan_lifecycle_id)
                                            ->pluck('flow_status');
                                        $options_select_permohonan_id = [];
                                        foreach ($data_lifecycle as $item) {
                                            foreach ($item as $roleData) {
                                                if ($roleData['condition_status'] == $get('status_permohonan_id') && $roleData['role'] == auth()->user()->roles->first()->id) {
                                                    $options_select_permohonan_id = $roleData['status'];
                                                    break;
                                                } else if ($roleData['condition_status'] == null && $roleData['role'] == auth()->user()->roles->first()->id) {
                                                    $options_select_permohonan_id = $roleData['status'];
                                                    break;
                                                }
                                            }
                                        }
                                        $final_relation_status_name = StatusPermohonan::whereIn('id', $options_select_permohonan_id)->pluck('nama_status', 'id')->toArray();
                                        $data['final_relation_status_name'] = $final_relation_status_name;
                                        return $final_relation_status_name;
                                    } else if ($operation === 'view') {
                                        return StatusPermohonan::pluck('nama_status', 'id')->toArray();
                                    } else {
                                        return $get('final_relation_status_name');
                                    }
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
                            Forms\Components\Checkbox::make('saya_setuju')
                                ->label('Ya, Saya Setuju!')
                                ->accepted(),
                            Hidden::make('nomor_rekomendasi'),
                            Hidden::make('nomor_izin'),
                        ]),
                ])->columnSpanFull()->nextAction(
                    fn (Action $action) => $action->label('Selanjutnya'),
                )->previousAction(
                    fn (Action $action) => $action->label('Sebelumnya'),
                )->skippable(auth()->user()->roles->first()->name != 'pemohon'),
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
                    ->searchable()
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
                Tables\Columns\TextColumn::make('user.name')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('nomor_izin')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Pengajuan')
                    ->date(format: 'd-m-Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('tanggal_izin_terbit')
                    ->date(format: 'd-m-Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                ExportAction::make()
                    ->exporter(TrackingExporter::class)
                    ->hidden(auth()->user()->roles->first()->name == 'pemohon')
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
                Filter::make('tanggal_izin_terbit')
                    ->form([
                        Forms\Components\DatePicker::make('tanggal_izin_terbit_from'),
                        Forms\Components\DatePicker::make('tanggal_izin_terbit_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['tanggal_izin_terbit_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal_izin_terbit', '>=', $date),
                            )
                            ->when(
                                $data['tanggal_izin_terbit_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal_izin_terbit', '<=', $date),
                            );
                    }),
                Filter::make('status_permohonan_id')
                    ->query(fn (Builder $query): Builder => $query->where('status_permohonan_id', 11))
                    ->label('Izin Terbit')
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
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
                                            TextEntry::make('Activity')->columnSpanFull(),
                                            TextEntry::make('Stake Holder'),
                                            TextEntry::make('Tanggal')->columnSpan(2)
                                        ])
                                ])
                                ->columnSpanFull(),
                        ]),
                ]),
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
            return $query->whereIn('perizinan_id', $get_assign_perizinan_handle['perizinan_id']);
        } else {
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
