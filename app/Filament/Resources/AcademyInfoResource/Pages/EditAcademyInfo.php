<?php

namespace App\Filament\Resources\AcademyInfoResource\Pages;

use App\Filament\Resources\AcademyInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAcademyInfo extends EditRecord
{
    protected static string $resource = AcademyInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
