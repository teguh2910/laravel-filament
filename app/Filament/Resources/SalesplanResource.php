<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalesplanResource\Pages;
use App\Filament\Resources\SalesplanResource\RelationManagers;
use App\Models\Salesplan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SalesplanResource extends Resource
{
    protected static ?string $model = Salesplan::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('part_number_assy')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('part_number_customer')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('part_name_customer')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('product')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('qty_fy24')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('part_number_assy')
                    ->searchable(),
                Tables\Columns\TextColumn::make('part_number_customer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('part_name_customer')
                    ->searchable(),
                Tables\Columns\TextColumn::make('product')
                    ->searchable(),
                Tables\Columns\TextColumn::make('qty_fy24')
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
            'index' => Pages\ListSalesplans::route('/'),
            'create' => Pages\CreateSalesplan::route('/create'),
            'edit' => Pages\EditSalesplan::route('/{record}/edit'),
        ];
    }
}
