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
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade'); // Allow null users for guest bookings
            $table->string('name')->nullable(); // User's name (nullable for guests)
            $table->json('services')->nullable(); // JSON array of services
            $table->date('date')->nullable(); // Allow nullable appointment date
            $table->time('time')->nullable(); // Allow nullable appointment time
            $table->string('therapist')->nullable(); // Therapist name (optional)
            $table->decimal('amount', 8, 2)->nullable(); // Allow null price
            $table->integer('quantity')->nullable(); // Allow null quantity
            $table->integer('duration')->nullable(); // Allow null duration
            $table->string('status')->default('pending'); // Default status to 'pending'
            $table->text('notes')->nullable(); // Additional notes (optional)
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
