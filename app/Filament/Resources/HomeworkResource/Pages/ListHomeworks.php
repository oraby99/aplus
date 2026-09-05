<?php

namespace App\Filament\Resources\HomeworkResource\Pages;

use App\Filament\Resources\HomeworkResource;
use App\Models\Homework;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListHomeworks extends ListRecords
{
    protected static string $resource = HomeworkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        $baseQuery = fn () => auth()->user()?->type === 'teacher'
            ? Homework::whereHas('group', fn ($q) => $q->where('teacher_id', auth()->id()))
            : (auth()->user()?->type === 'student' ? Homework::where('student_id', auth()->id()) : Homework::query());

        return [
            'all' => Tab::make('الكل')
                ->badge($baseQuery()->count()),

            'pending' => Tab::make('قيد المراجعة ⏳')
                ->badge($baseQuery()->where('status', 'pending')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending')),

            'approved' => Tab::make('معتمد وممتاز 🌟')
                ->badge($baseQuery()->where('status', 'approved')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'approved')),

            'needs_revision' => Tab::make('يحتاج تعديل ✏️')
                ->badge($baseQuery()->where('status', 'needs_revision')->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'needs_revision')),
        ];
    }
}
