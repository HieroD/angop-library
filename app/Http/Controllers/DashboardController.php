<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;

class DashboardController extends Controller
{
    public function admin()
    {
        $admin = auth('staff')->user();

        $totalBuku = Book::query()->count();

        $totalAnggota = Member::query()->count();

        $totalPeminjamanAktif = Borrowing::query()
            ->where('status', 'dipinjam')
            ->count();

        $totalTerlambat = Borrowing::query()
            ->where('status', 'terlambat')
            ->count();

        $peminjamanTerbaru = Borrowing::query()
            ->with('member', 'book')
            ->latest()
            ->take(5)
            ->get();

        $statuses = [
            'menunggu konfirmasi' => ['label' => 'Menunggu Konfirmasi', 'class' => 'bg-gray-100 text-gray-800'],
            'dipinjam' => ['label' => 'Dipinjam', 'class' => 'bg-blue-100 text-blue-800'],
            'dikembalikan' => ['label' => 'Dikembalikan', 'class' => 'bg-emerald-100 text-emerald-800'],
            'terlambat' => ['label' => 'Terlambat', 'class' => 'bg-rose-100 text-rose-800'],
        ];

        return view('admin.dashboard', compact(
            'admin',
            'totalBuku',
            'totalAnggota',
            'totalPeminjamanAktif',
            'totalTerlambat',
            'peminjamanTerbaru',
            'statuses',
        ));
    }
}
