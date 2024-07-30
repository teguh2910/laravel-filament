<?php

namespace App\Filament\Resources;

use App\Filament\Resources\APRResource\Pages;
use App\Models\APR;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class APRResource extends Resource
{
    protected static ?string $model = APR::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('supplier_id')
                    ->required()
                    ->relationship(name: 'suppliers', titleAttribute: 'nama_supplier')
                    ->searchable(),
                Forms\Components\Select::make('periode')
                    ->required()
                    ->label('Periode')
                    ->options([
                        'Q1' => 'Q1',
                        'Q2' => 'Q2',
                        'Q3' => 'Q3',
                        'Q4' => 'Q4',
                        'S1' => 'S1',
                        'S2' => 'S2',
                    ])
                    ->searchable(),
                Forms\Components\FileUpload::make('file'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('suppliers.nama_supplier')
                    ->label('Supplier')
                    ->sortable(),
                Tables\Columns\TextColumn::make('periode')
                    ->searchable(),
                Tables\Columns\TextColumn::make('file')
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
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAPRS::route('/'),
            'create' => Pages\CreateAPR::route('/create'),
            'edit' => Pages\EditAPR::route('/{record}/edit'),
        ];
    }
}
