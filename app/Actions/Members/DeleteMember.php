<?php

namespace App\Actions\Members;

use App\Models\Member;

class DeleteMember
{
    public function handle(Member $member): void
    {
        $member->delete();
    }
}
