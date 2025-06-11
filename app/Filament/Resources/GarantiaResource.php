<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GarantiaResource\Pages;
use App\Filament\Resources\GarantiaResource\RelationManagers;
use App\Models\Garantia;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;


class GarantiaResource extends Resource
{
    protected static ?string $model = Garantia::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('codigo_garantia')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('ticket')
                    ->required()
                    ->maxLength(255),
                // Forms\Components\TextInput::make('cliente_id')
                //     ->required()
                //     ->numeric(),
                Select::make('cliente_id')
                    ->preload()
                    ->relationship(name: 'cliente', titleAttribute: 'nombre')
                    ->searchable(['nombre', 'apellidos'])
                    ->getOptionLabelFromRecordUsing(fn (Model $record) => "{$record->apellidos} {$record->nombre}"),

                Select::make('estado')
                    ->options([
                        'Abierto' => 'Abierto',
                        'Cerrado' => 'Cerrado',
                    ])
                    ->default('Abierto')
                    ->required(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('codigo_garantia')
                    ->searchable(),
                Tables\Columns\TextColumn::make('ticket')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cliente.apellidos')
                    ->label('Cliente')
                    ->formatStateUsing(fn ($state, $record) => "{$record->cliente->apellidos} {$record->cliente->nombre}")
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('estado'),
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
            'index' => Pages\ListGarantias::route('/'),
            'create' => Pages\CreateGarantia::route('/create'),
            'edit' => Pages\EditGarantia::route('/{record}/edit'),
        ];
    }
}
