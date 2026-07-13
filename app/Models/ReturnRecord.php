<?php

namespace App\Models;

use Database\Factories\ReturnRecordFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturnRecord extends Model
{
    /** @use HasFactory<ReturnRecordFactory> */
    use HasFactory;

    protected $table = 'returns';

    protected $fillable = [
        'borrowing_id',
        'staff_id',
        'return_date',
        'fine_amount',
        'paid_amount',
        'payment_status',
        'fine_reason',
    ];

    protected function casts(): array
    {
        return [
            'return_date' => 'datetime',
            'fine_amount' => 'decimal:2',
            'paid_amount' => 'decimal:2',
        ];
    }

    public function borrowing(): BelongsTo
    {
        return $this->belongsTo(Borrowing::class);
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }
}
