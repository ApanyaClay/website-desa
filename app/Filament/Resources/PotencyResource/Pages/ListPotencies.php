<?php

namespace App\Filament\Resources\PotencyResource\Pages;

use App\Filament\Resources\PotencyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPotencies extends ListRecords
{
    protected static string $resource = PotencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
