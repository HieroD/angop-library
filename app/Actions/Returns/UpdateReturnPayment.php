<?php

namespace App\Actions\Returns;

use App\Models\ReturnRecord;
use Illuminate\Support\Facades\DB;

class UpdateReturnPayment
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function handle(ReturnRecord $returnRecord, array $data): ReturnRecord
    {
        return DB::transaction(function () use ($returnRecord, $data): ReturnRecord {
            $paidAmount = min(
                (float) $returnRecord->fine_amount,
                (float) $returnRecord->paid_amount + (float) $data['amount'],
            );

            $returnRecord->update([
                'paid_amount' => $paidAmount,
                'payment_status' => $paidAmount >= (float) $returnRecord->fine_amount ? 'paid' : 'unpaid',
            ]);

            return $returnRecord;
        });
    }
}
