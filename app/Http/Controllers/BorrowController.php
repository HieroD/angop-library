<?php

namespace App\Http\Controllers;

use App\Actions\Borrowings\ApproveBorrowing;
use App\Actions\Borrowings\RejectBorrowing;
use App\Http\Requests\Borrowings\ApproveBorrowingRequest;
use App\Http\Requests\Borrowings\RejectBorrowingRequest;
use App\Models\Borrowing;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class BorrowController extends Controller
{
    public function index(): View
    {
        $pendingBorrowings = Borrowing::query()
            ->with(['member', 'book'])
            ->where('status', 'menunggu konfirmasi')
            ->latest()
            ->paginate(5, ['*'], 'pending_page');

        $historyBorrowings = Borrowing::query()
            ->with(['member', 'book', 'staff'])
            ->whereIn('status', ['dipinjam', 'ditolak'])
            ->latest('updated_at')
            ->paginate(5, ['*'], 'history_page');

        return view('admin.borrowings.index', compact('pendingBorrowings', 'historyBorrowings'));
    }

    public function approve(ApproveBorrowingRequest $request, Borrowing $borrowing, ApproveBorrowing $approveBorrowing): RedirectResponse
    {
        $approveBorrowing->handle($borrowing, auth('staff')->user());

        return back()->with('success', 'Permohonan peminjaman disetujui.');
    }

    public function reject(RejectBorrowingRequest $request, Borrowing $borrowing, RejectBorrowing $rejectBorrowing): RedirectResponse
    {
        $rejectBorrowing->handle($borrowing, auth('staff')->user());

        return back()->with('success', 'Permohonan peminjaman ditolak.');
    }
}
