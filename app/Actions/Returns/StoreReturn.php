<?php

namespace App\Actions\Returns;

use App\Models\Borrowing;
use App\Models\ReturnRecord;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;

class StoreReturn
{
    public function handle(Borrowing $borrowing, Staff $staff): ReturnRecord
    {
        return DB::transaction(function () use ($borrowing, $staff): ReturnRecord {
            $overdueDays = max(0, now()->startOfDay()->diffInDays($borrowing->due_date, false) * -1);
            $fineAmount = $overdueDays * 1000;

            $returnRecord = ReturnRecord::query()->create([
                'borrowing_id' => $borrowing->id,
                'staff_id' => $staff->id,
                'return_date' => now(),
                'fine_amount' => $fineAmount,
                'payment_status' => $fineAmount > 0 ? 'unpaid' : 'paid',
                'fine_reason' => $overdueDays > 0 ? "Terlambat {$overdueDays} hari" : null,
            ]);

            $borrowing->update([
                'returned_at' => now(),
                'status' => 'dikembalikan',
            ]);

            return $returnRecord;
        });
    }
}
