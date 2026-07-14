<?php

namespace App\Http\Controllers;

use App\Actions\Members\DeleteMember;
use App\Actions\Members\StoreMember;
use App\Actions\Members\UpdateMember;
use App\Http\Requests\Members\DestroyMemberRequest;
use App\Http\Requests\Members\StoreMemberRequest;
use App\Http\Requests\Members\UpdateMemberRequest;
use App\Models\Member;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class MemberController extends Controller
{
    public function index(): View
    {
        $members = Member::query()
            ->withCount('borrowings')
            ->latest()
            ->paginate(7);

        return view('admin.members.index', compact('members'));
    }

    public function store(StoreMemberRequest $request, StoreMember $storeMember): RedirectResponse
    {
        $storeMember->handle($request->validated(), auth('staff')->user());

        return back()->with('success', 'Anggota berhasil ditambahkan.');
    }

    public function update(UpdateMemberRequest $request, Member $member, UpdateMember $updateMember): RedirectResponse
    {
        $updateMember->handle($member, $request->validated());

        return back()->with('success', 'Anggota berhasil diperbarui.');
    }

    public function destroy(DestroyMemberRequest $request, Member $member, DeleteMember $deleteMember): RedirectResponse
    {
        $deleteMember->handle($member);

        return back()->with('success', 'Anggota berhasil dihapus.');
    }
}
