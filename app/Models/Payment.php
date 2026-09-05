<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function installments(): HasMany
    {
        return $this->hasMany(Installment::class);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function getRemainingAmountAttribute(): float
    {
        return (float) max(0, $this->total_amount - $this->paid_amount - $this->discount);
    }

    public function getNextDueDateAttribute(): ?\Carbon\Carbon
    {
        // 1. Check if there are unpaid installments
        $nextInstallment = $this->installments()
            ->where('status', '!=', 'paid')
            ->orderBy('due_date')
            ->first();

        if ($nextInstallment && $nextInstallment->due_date) {
            return $nextInstallment->due_date;
        }

        // 2. Return payment's own due date if set
        if ($this->due_date) {
            return $this->due_date;
        }

        return null;
    }

    public function getIsOverdueAttribute(): bool
    {
        if ($this->status === 'overdue') {
            return true;
        }

        if ($this->remaining_amount <= 0) {
            return false;
        }

        $nextDue = $this->next_due_date;
        if ($nextDue && $nextDue->isPast() && !$nextDue->isToday()) {
            return true;
        }

        return false;
    }

    public function scopeOverdue(Builder $query): Builder
    {
        return $query->where(function (Builder $q) {
            $q->where('status', 'overdue')
                ->orWhere(function (Builder $sq) {
                    $sq->whereRaw('(total_amount - paid_amount - discount) > 0')
                        ->where(function (Builder $sub) {
                            $sub->whereHas('installments', function (Builder $iq) {
                                $iq->where('status', 'overdue')
                                    ->orWhere(fn (Builder $dq) => $dq->where('status', '!=', 'paid')->whereDate('due_date', '<', now()->toDateString()));
                            })
                            ->orWhere(function (Builder $dq) {
                                $dq->whereNotNull('due_date')
                                    ->whereDate('due_date', '<', now()->toDateString());
                            });
                        });
                });
        });
    }

    public function scopeDueSoon(Builder $query): Builder
    {
        return $query->where(function (Builder $q) {
            $q->whereIn('status', ['pending', 'partial'])
                ->where('status', '!=', 'overdue')
                ->whereRaw('(total_amount - paid_amount - discount) > 0')
                ->where(function (Builder $sub) {
                    $sub->whereDoesntHave('installments', function (Builder $iq) {
                        $iq->where('status', 'overdue')
                            ->orWhere(fn (Builder $dq) => $dq->where('status', '!=', 'paid')->whereDate('due_date', '<', now()->toDateString()));
                    })
                    ->where(function (Builder $dq) {
                        $dq->whereNull('due_date')
                            ->orWhereDate('due_date', '>=', now()->toDateString());
                    });
                });
        });
    }

    public function scopeHasRemaining(Builder $query): Builder
    {
        return $query->whereRaw('(total_amount - paid_amount - discount) > 0');
    }

    public function scopeFullyPaid(Builder $query): Builder
    {
        return $query->where('status', 'paid')
            ->orWhereRaw('(total_amount - paid_amount - discount) <= 0');
    }
}
