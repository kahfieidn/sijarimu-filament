<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use App\Models\PerizinanConfiguration;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PerizinanConfigurationResource\Pages;
use App\Filament\Resources\PerizinanConfigurationResource\RelationManagers;

class PerizinanConfigurationResource extends Resource
{
    protected static ?string $model = PerizinanConfiguration::class;

    protected static ?string $navigationIcon = 'heroicon-o-queue-list';

    protected static ?string $navigationGroup = 'System Configuration';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Perizinan Configuration Information')
                    ->schema([
                        Forms\Components\TextInput::make('nama_configuration')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('prefix_nomor_rekomendasi')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('suffix_nomor_rekomendasi')
                            ->required(),
                        Forms\Components\TextInput::make('nomor_rekomendasi')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('prefix_nomor_izin')
                            ->required(),
                        Forms\Components\TextInput::make('suffix_nomor_izin')
                            ->required(),
                        Forms\Components\TextInput::make('nomor_izin')
                            ->required()
                            ->numeric()
                            ->columnSpanFull(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_configuration')
                    ->searchable(),
                Tables\Columns\TextColumn::make('prefix_nomor_rekomendasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('suffix_nomor_rekomendasi')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nomor_rekomendasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('prefix_nomor_izin')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('suffix_nomor_izin')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nomor_izin')
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPerizinanConfigurations::route('/'),
            'create' => Pages\CreatePerizinanConfiguration::route('/create'),
            'view' => Pages\ViewPerizinanConfiguration::route('/{record}'),
            'edit' => Pages\EditPerizinanConfiguration::route('/{record}/edit'),
        ];
    }
}
