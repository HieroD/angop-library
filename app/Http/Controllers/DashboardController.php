<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Member;
use App\Models\ReturnRecord;

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

    public function member()
    {
        $member = auth('member')->user();

        $bukuSedangDipinjam = Borrowing::query()
            ->where('member_id', $member->id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->count();

        $totalBukuDipinjam = Borrowing::query()
            ->where('member_id', $member->id)
            ->count();

        $totalDenda = ReturnRecord::query()
            ->whereHas('borrowing', fn ($q) => $q->where('member_id', $member->id))
            ->where('payment_status', 'unpaid')
            ->selectRaw('COALESCE(SUM(fine_amount - paid_amount), 0) as total')
            ->value('total');

        $peminjamanAktif = Borrowing::query()
            ->with('book.authors')
            ->where('member_id', $member->id)
            ->whereIn('status', ['dipinjam', 'terlambat'])
            ->latest('borrow_date')
            ->get();

        $bukuRekomendasi = Book::query()
            ->with('category', 'authors')
            ->where('total_copies', '>', 0)
            ->inRandomOrder()
            ->take(6)
            ->get();

        $riwayatPeminjaman = Borrowing::query()
            ->with('book.authors')
            ->where('member_id', $member->id)
            ->whereIn('status', ['dikembalikan', 'ditolak'])
            ->latest('updated_at')
            ->take(5)
            ->get();

        return view('member.dashboard', compact(
            'member',
            'bukuSedangDipinjam',
            'totalBukuDipinjam',
            'totalDenda',
            'peminjamanAktif',
            'bukuRekomendasi',
            'riwayatPeminjaman',
        ));
    }
}
