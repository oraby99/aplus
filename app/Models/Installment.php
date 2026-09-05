<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Installment extends Model
{
    protected $guarded = [];

    protected $casts = [
        'due_date' => 'date',
        'paid_date' => 'date',
    ];

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }

    public function getIsOverdueAttribute(): bool
    {
        return $this->status !== 'paid' && 
               $this->due_date && 
               $this->due_date->isPast() && 
               !$this->due_date->isToday();
    }

    public function getEffectiveStatusAttribute(): string
    {
        if ($this->status === 'paid') {
            return 'paid';
        }

        if ($this->is_overdue) {
            return 'overdue';
        }

        return $this->status ?? 'pending';
    }

    public function scopeOverdue(Builder $query): Builder
    {
        return $query->where('status', 'overdue')
            ->orWhere(function (Builder $q) {
                $q->where('status', '!=', 'paid')
                  ->whereDate('due_date', '<', now()->toDateString());
            });
    }

    public function scopeDueSoon(Builder $query): Builder
    {
        return $query->where('status', 'pending')
            ->where(function (Builder $q) {
                $q->whereNull('due_date')
                  ->orWhereDate('due_date', '>=', now()->toDateString());
            });
    }

    public function scopePaid(Builder $query): Builder
    {
        return $query->where('status', 'paid');
    }

    protected static function booted(): void
    {
        static::saved(function (Installment $installment) {
            $installment->syncPaymentTotals();
        });

        static::deleted(function (Installment $installment) {
            $installment->syncPaymentTotals();
        });
    }

    public function syncPaymentTotals(): void
    {
        if ($this->payment) {
            $payment = $this->payment;
            $totalPaid = $payment->installments()->where('status', 'paid')->sum('amount');
            $hasUnpaidOverdue = $payment->installments()->where('status', '!=', 'paid')->whereDate('due_date', '<', now()->toDateString())->exists();
            $allPaid = $payment->installments()->count() > 0 && !$payment->installments()->where('status', '!=', 'paid')->exists();

            $newStatus = $payment->status;
            if ($allPaid || ($payment->total_amount - $payment->discount <= $totalPaid && $totalPaid > 0)) {
                $newStatus = 'paid';
            } elseif ($hasUnpaidOverdue) {
                $newStatus = 'overdue';
            } elseif ($totalPaid > 0) {
                $newStatus = 'partial';
            }

            $payment->update([
                'paid_amount' => $totalPaid,
                'status' => $newStatus,
            ]);
        }
    }
}
