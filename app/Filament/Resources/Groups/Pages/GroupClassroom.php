<?php

namespace App\Filament\Resources\Groups\Pages;

use App\Filament\Resources\Groups\GroupResource;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Contracts\Support\Htmlable;

class GroupClassroom extends ViewRecord
{
    protected static string $resource = GroupResource::class;

    protected string $view = 'filament.resources.groups.pages.classroom';

    public function getMaxContentWidth(): \Filament\Support\Enums\Width|string|null
    {
        return \Filament\Support\Enums\Width::Full;
    }

    public function getTitle(): string | Htmlable
    {
        return __('الفصل الافتراضي') . ' - ' . $this->record->name;
    }

    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\EditAction::make('edit_zoom')
                ->label('إضافة / تعديل رابط Zoom')
                ->icon('heroicon-o-video-camera')
                ->color('primary')
                ->form([
                    \Filament\Forms\Components\TextInput::make('zoom_link')
                        ->label('رابط Zoom')
                        ->url()
                        ->maxLength(255),
                    \Filament\Forms\Components\TextInput::make('zoom_meeting_id')
                        ->label('رقم الاجتماع (ID)')
                        ->maxLength(255),
                    \Filament\Forms\Components\TextInput::make('zoom_password')
                        ->label('كلمة المرور')
                        ->maxLength(255),
                ])
                ->visible(fn () => auth()->user()->hasRole('super_admin') || auth()->user()->id === $this->record->teacher_id),
        ];
    }
}
