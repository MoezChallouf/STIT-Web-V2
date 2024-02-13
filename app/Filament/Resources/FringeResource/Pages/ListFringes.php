<?php

namespace App\Filament\Resources\FringeResource\Pages;

use App\Filament\Resources\FringeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFringes extends ListRecords
{
    protected static string $resource = FringeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
