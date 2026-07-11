<?php

namespace App\Filament\Resources\TrialSessionResource\Pages;

use App\Filament\Resources\TrialSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrialSession extends EditRecord
{
    protected static string $resource = TrialSessionResource::class;

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
