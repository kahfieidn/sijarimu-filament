<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use App\Models\Perizinan;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Filament\Infolists\Components\TextEntry;
use App\Filament\Resources\PerizinanResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PerizinanResource\RelationManagers;

class PerizinanResource extends Resource
{
    protected static ?string $model = Perizinan::class;

    protected static ?string $pluralModelLabel = 'Persyaratan';
    protected static ?string $navigationGroup = 'Docs';
    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Detail Perizinan')
                    ->schema([
                        Forms\Components\Select::make('sektor_id')
                            ->options(fn () => \App\Models\Sektor::pluck('nama_sektor', 'id'))
                            ->required(),
                        Forms\Components\TextInput::make('nama_perizinan')
                            ->required()
                            ->maxLength(255),
                        // Forms\Components\Select::make('perizinan_life_cycle_id')
                        //     ->options(fn () => \App\Models\PerizinanLifecycle::pluck('flow', 'id'))
                        //     ->required(),
                        Forms\Components\Select::make('perizinan_lifecycle_id')
                            ->options(fn () => \App\Models\PerizinanLifecycle::pluck('nama_flow', 'id'))
                            ->searchable()
                            ->required(),
                        Forms\Components\Select::make('perizinan_configuration_id')
                            ->options(fn () => \App\Models\PerizinanConfiguration::pluck('nama_configuration', 'id'))
                            ->searchable()
                            ->required(),
                        Forms\Components\Toggle::make('is_template_rekomendasi')
                            ->onIcon('heroicon-m-bolt')
                            ->offIcon('heroicon-m-user'),
                        Forms\Components\Toggle::make('is_template_izin')
                            ->onIcon('heroicon-m-bolt')
                            ->offIcon('heroicon-m-user'),
                        Forms\Components\Textarea::make('template_rekomendasi'),
                        Forms\Components\Textarea::make('template_izin'),
                        Forms\Components\Toggle::make('is_save_as_template_rekomendasi')
                            ->onIcon('heroicon-m-bolt')
                            ->offIcon('heroicon-m-user'),
                        Forms\Components\Toggle::make('is_save_as_template_izin')
                            ->onIcon('heroicon-m-bolt')
                            ->offIcon('heroicon-m-user'),
                        Forms\Components\Toggle::make('is_active')
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sektor.nama_sektor')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_perizinan')
                    ->wrap()
                    ->searchable(),
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
                Tables\Actions\ViewAction::make()
                    ->visible(auth()->user()->roles->first()->name == 'super_admin'),
                Tables\Actions\EditAction::make()
                    ->visible(auth()->user()->roles->first()->name == 'super_admin'),
                Tables\Actions\Action::make('Lihat Berkas')
                    ->icon('heroicon-s-arrow-trending-up')
                    ->infolist([
                        TextEntry::make('persyaratan.nama_persyaratan')
                            ->listWithLineBreaks()
                            ->bulleted()
                            ->lineClamp(2)
                            ->expandableLimitedList()
                            ->copyable()
                    ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListPerizinans::route('/'),
            'create' => Pages\CreatePerizinan::route('/create'),
            'view' => Pages\ViewPerizinan::route('/{record}'),
            'edit' => Pages\EditPerizinan::route('/{record}/edit'),
        ];
    }
}
