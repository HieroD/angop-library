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
        Schema::create('returns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('borrowing_id')
                ->unique()
                ->constrained('borrowings')
                ->cascadeOnDelete();
            $table->foreignId('staff_id')
                ->constrained('staffs')
                ->cascadeOnDelete();
            $table->timestamp('return_date')->useCurrent();
            $table->decimal('fine_amount', 10, 2)->default(0.00);
            $table->enum('payment_status', ['unpaid', 'paid'])->default('unpaid');
            $table->string('fine_reason', 255)->nullable();
            $table->timestamps();

            $table->index('payment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
