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
        Schema::create('payments', function (Blueprint $table) {
        $table->id();
        $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
        $table->decimal('amount', 10, 2);
        $table->date('payment_date')->default(now());
        $table->enum('payment_method', ['cash', 'card', 'bank_transfer']);
        $table->string('receipt_number', 100)->nullable();
        $table->string('notes', 200)->nullable();
        $table->foreignId('recorded_by')->constrained('users')->onDelete('cascade');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
