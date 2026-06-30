<?php

namespace App\Filament\Resources\PotencyResource\Pages;

use App\Filament\Resources\PotencyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPotency extends EditRecord
{
    protected static string $resource = PotencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
