<?php

namespace App\Filament\Resources\APRResource\Pages;

use App\Filament\Resources\APRResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAPRS extends ListRecords
{

    protected static string $resource = APRResource::class;

    protected function getHeaderActions(): array
    {
        return [
            \EightyNine\ExcelImport\ExcelImportAction::make()
                ->color("primary"),
            Actions\CreateAction::make(),
        ];
    }
    /**
     * Get the completion action.
     *
     * @return Filament\Actions\Action
     * @throws Exception
     */
}
