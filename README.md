# Angop Library - Sistem Informasi Perpustakaan Digital

A web-based library management system built with Laravel. Members can browse the catalog, borrow books online, and track their borrowing history. Admins manage books, members, borrow requests, and returns.

## Fitur

### Guest
- Landing page with feature overview
- Login page (multi-guard: staff & member)

### Member
- **Dashboard**: stats (buku sedang dipinjam, total buku dipinjam, total denda), active borrowings list, borrowing history, book recommendations
- **Katalog Buku**: search, filter by category, sort, paginated grid, stock indicators
- **Detail Buku**: full metadata, description, borrow button with confirmation modal
- **Aturan Peminjaman**: guide to the borrowing & return flow
- **Peminjaman**: submit borrow request (status: `menunggu konfirmasi`)

### Admin
- **Dashboard**: total books, members, active borrowings, overdue books, recent requests
- **Kelola Buku**: CRUD with search, category filter, stock management
- **Kelola Anggota**: CRUD with auto-generated member codes
- **Kelola Peminjaman**: approve/reject pending requests with confirmation modals
- **Kelola Pengembalian**: process returns, calculate overdue fines (Rp 1.000/day)

## Tech Stack

| Layer | Stack |
|-------|-------|
| Backend | PHP 8.4, Laravel 13 |
| Frontend | Blade, Tailwind CSS v4, Alpine.js |
| Database | MySQL |
| Build | Vite |

## Installation

```bash
git clone <repo-url>
cd angop-library

composer install
cp .env.example .env
php artisan key:generate

# Configure database in .env, then:
php artisan migrate

npm install
npm run build

php artisan storage:link
```

## Default Credentials

Run the seeder to create initial accounts:

```bash
php artisan db:seed
```


