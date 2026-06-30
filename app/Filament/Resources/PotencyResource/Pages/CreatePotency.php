<?php

namespace App\Filament\Resources\PotencyResource\Pages;

use App\Filament\Resources\PotencyResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePotency extends CreateRecord
{
    protected static string $resource = PotencyResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
