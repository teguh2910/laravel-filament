<?php

namespace App\Filament\Resources\SalesplanResource\Pages;

use App\Filament\Resources\SalesplanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSalesplans extends ListRecords
{
    protected static string $resource = SalesplanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \EightyNine\ExcelImport\ExcelImportAction::make()
                ->color("primary"),
            Actions\CreateAction::make(),
        ];
    }
}
