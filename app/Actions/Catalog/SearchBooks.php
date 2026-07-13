<?php

namespace App\Actions\Catalog;

use App\Models\Book;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class SearchBooks
{
    /**
     * @param  array<string, mixed>  $filters
     */
    public function handle(array $filters): LengthAwarePaginator
    {
        return Book::query()
            ->with(['authors', 'category'])
            ->when($filters['search'] ?? null, function ($query, string $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhereHas('authors', fn ($q) => $q->where('name', 'like', "%{$search}%"));
            })
            ->when($filters['category_id'] ?? null, fn ($query, int $id) => $query->where('category_id', $id))
            ->when($filters['sort'] ?? null, function ($query, string $sort) {
                match ($sort) {
                    'judul-az' => $query->orderBy('title'),
                    'stok-tersedia' => $query->orderByDesc('total_copies'),
                    default => $query->latest(),
                };
            }, fn ($query) => $query->latest())
            ->paginate(12);
    }
}
