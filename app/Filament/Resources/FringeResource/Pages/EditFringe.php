<?php

namespace App\Filament\Resources\FringeResource\Pages;

use App\Filament\Resources\FringeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFringe extends EditRecord
{
    protected static string $resource = FringeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
