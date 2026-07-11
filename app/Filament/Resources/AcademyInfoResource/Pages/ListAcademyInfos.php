<?php

namespace App\Filament\Resources\AcademyInfoResource\Pages;

use App\Filament\Resources\AcademyInfoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAcademyInfos extends ListRecords
{
    protected static string $resource = AcademyInfoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
