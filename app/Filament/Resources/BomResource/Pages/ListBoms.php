<?php

namespace App\Filament\Resources\BomResource\Pages;

use App\Filament\Resources\BomResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBoms extends ListRecords
{
    protected static string $resource = BomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \EightyNine\ExcelImport\ExcelImportAction::make()
                ->color("primary"),
            Actions\CreateAction::make(),
            
        ];
    }
}
