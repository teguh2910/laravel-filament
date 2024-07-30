<?php

namespace App\Filament\Resources\APRResource\Pages;

use App\Filament\Resources\APRResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAPR extends EditRecord
{
    protected static string $resource = APRResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
