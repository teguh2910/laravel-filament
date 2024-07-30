<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BomResource\Pages;
use App\Filament\Resources\BomResource\RelationManagers;
use App\Models\Bom;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportAction;

class BomResource extends Resource
{
    protected static ?string $model = Bom::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('level')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('part_number_comp')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('part_name_comp')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('part_number_assy')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('part_name_assy')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('qty_usage_for_assy')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('uom')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table

            ->columns([
                Tables\Columns\TextColumn::make('level')
                    ->label('lv')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('part_number_comp')
                    ->label('part_component')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('part_name_comp')
                    ->label('part_name_component')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('part_number_assy')
                    ->label('part_assy')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('part_name_assy')
                    ->label('part_assy')
                    ->searchable(isIndividual: true),
                Tables\Columns\TextColumn::make('qty_usage_for_assy')
                    ->label('qty_usage')
                    ->numeric(),
                Tables\Columns\TextColumn::make('qty.qty_fy24')
                    ->label('qty_sp')
                    ->numeric(),
                Tables\Columns\TextColumn::make('price.price_ori')
                    ->label('price_ori')
                    ->numeric(),
                Tables\Columns\TextColumn::make('supplier.supplier')
                    ->numeric(),
                Tables\Columns\TextColumn::make('uom')
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
                Tables\Actions\EditAction::make(),
            ])
            ->headerActions([
                ExportAction::make(),

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
            'index' => Pages\ListBoms::route('/'),
            'create' => Pages\CreateBom::route('/create'),
            'edit' => Pages\EditBom::route('/{record}/edit'),
        ];
    }
}
