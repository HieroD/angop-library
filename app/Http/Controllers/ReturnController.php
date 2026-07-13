<?php

namespace App\Http\Controllers;

use App\Actions\Returns\StoreReturn;
use App\Http\Requests\Returns\StoreReturnRequest;
use App\Models\Borrowing;
use App\Models\ReturnRecord;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ReturnController extends Controller
{
    public function index(): View
    {
        $activeBorrowings = Borrowing::query()
            ->with(['member', 'book'])
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->latest('due_date')
            ->paginate(5, ['*'], 'active_page');

        $returnHistory = ReturnRecord::query()
            ->with(['borrowing.member', 'borrowing.book', 'staff'])
            ->latest('return_date')
            ->paginate(5, ['*'], 'history_page');

        return view('admin.returns.index', compact('activeBorrowings', 'returnHistory'));
    }

    public function store(StoreReturnRequest $request, Borrowing $borrowing, StoreReturn $storeReturn): RedirectResponse
    {
        $storeReturn->handle($borrowing, auth('staff')->user());

        return back()->with('success', 'Buku berhasil dikembalikan.');
    }
}
