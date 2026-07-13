<?php

namespace App\Actions\Borrowings;

use App\Models\Borrowing;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;

class ApproveBorrowing
{
    public function handle(Borrowing $borrowing, Staff $staff): Borrowing
    {
        return DB::transaction(function () use ($borrowing, $staff): Borrowing {
            $borrowing->update([
                'staff_id' => $staff->id,
                'borrow_date' => now(),
                'due_date' => now()->addDays(7),
                'status' => 'dipinjam',
            ]);

            return $borrowing;
        });
    }
}
