<?php

namespace App\Actions\Members;

use App\Models\Member;
use App\Models\Staff;

class StoreMember
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function handle(array $data, Staff $staff): Member
    {
        return Member::query()->create([
            'member_code' => $this->nextMemberCode(),
            'staff_id' => $staff->id,
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
            'phone' => $data['phone'] ?? null,
            'gender' => $data['gender'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'address' => $data['address'] ?? null,
        ]);
    }

    private function nextMemberCode(): string
    {
        $nextId = ((int) Member::query()->max('id')) + 1;

        return 'MBR-'.str_pad((string) $nextId, 3, '0', STR_PAD_LEFT);
    }
}
