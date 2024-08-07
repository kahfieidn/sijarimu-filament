<?php

namespace App\Filament\Resources\PerizinanResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Resources\RelationManagers\RelationManager;

class PersyaratansRelationManager extends RelationManager
{
    protected static string $relationship = 'persyaratan';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('perizinan_id')
                    ->options(fn () => \App\Models\Perizinan::pluck('nama_perizinan', 'id'))
                    ->default($this->getOwnerRecord()->id)
                    ->preload()
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('nama_persyaratan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('template')
                    ->columnSpanFull()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('deskripsi_persyaratan')
                    ->default('<p>Berkas wajib di isi...</p>')
                    ->columnSpanFull()
            ])->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_persyaratan')
            ->columns([
                Tables\Columns\TextColumn::make('nama_persyaratan'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
