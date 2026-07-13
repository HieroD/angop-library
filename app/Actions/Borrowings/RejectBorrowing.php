<?php

namespace App\Actions\Borrowings;

use App\Models\Borrowing;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;

class RejectBorrowing
{
    public function handle(Borrowing $borrowing, Staff $staff): Borrowing
    {
        return DB::transaction(function () use ($borrowing, $staff): Borrowing {
            $borrowing->update([
                'staff_id' => $staff->id,
                'status' => 'ditolak',
            ]);

            return $borrowing;
        });
    }
}
