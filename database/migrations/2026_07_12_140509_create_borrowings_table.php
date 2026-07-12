<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('borrowings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('book_id')
                ->constrained('books')
                ->cascadeOnDelete();
            $table->foreignId('member_id')
                ->constrained('members')
                ->cascadeOnDelete();
            $table->foreignId('staff_id')
                ->constrained('staffs')
                ->cascadeOnDelete();
            $table->timestamp('borrow_date')->useCurrent();
            $table->date('due_date');
            $table->timestamp('returned_at')->nullable();
            $table->enum('status', ['menunggu konfirmasi', 'dipinjam', 'dikembalikan', 'terlambat'])->default('menunggu konfirmasi');
            $table->timestamps();

            $table->index('status');
            $table->index('member_id');
            $table->index('book_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowings');
    }
};
