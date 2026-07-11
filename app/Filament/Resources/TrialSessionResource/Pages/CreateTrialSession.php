<?php

namespace App\Filament\Resources\TrialSessionResource\Pages;

use App\Filament\Resources\TrialSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateTrialSession extends CreateRecord
{
    protected static string $resource = TrialSessionResource::class;


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
