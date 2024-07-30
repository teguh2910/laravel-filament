<?php

namespace App\Filament\Resources\SalesplanResource\Pages;

use App\Filament\Resources\SalesplanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSalesplan extends EditRecord
{
    protected static string $resource = SalesplanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
