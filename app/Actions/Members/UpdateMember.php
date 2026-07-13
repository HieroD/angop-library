<?php

namespace App\Actions\Members;

use App\Models\Member;

class UpdateMember
{
    /**
     * @param  array<string, mixed>  $data
     */
    public function handle(Member $member, array $data): Member
    {
        $payload = [
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'gender' => $data['gender'] ?? null,
            'date_of_birth' => $data['date_of_birth'] ?? null,
            'address' => $data['address'] ?? null,
        ];

        if (! empty($data['password'])) {
            $payload['password'] = $data['password'];
        }

        $member->update($payload);

        return $member;
    }
}
