<?php

namespace App\Filament\Resources\SuppliersrResource\Pages;

use App\Filament\Resources\SuppliersrResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSuppliersrs extends ListRecords
{
    protected static string $resource = SuppliersrResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \EightyNine\ExcelImport\ExcelImportAction::make()
                ->color("primary"),
            Actions\CreateAction::make(),
        ];
    }
}
