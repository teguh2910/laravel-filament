<?php

namespace App\Filament\Resources\SuppliersrResource\Pages;

use App\Filament\Resources\SuppliersrResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSuppliersr extends EditRecord
{
    protected static string $resource = SuppliersrResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
