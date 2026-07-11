<?php

namespace App\Filament\Resources\TrialSessionResource\Pages;

use App\Filament\Resources\TrialSessionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrialSessions extends ListRecords
{
    protected static string $resource = TrialSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
