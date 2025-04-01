<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('appointment_slots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->time('time');
            $table->string('therapist')->nullable();
            $table->date('date');
            $table->integer('booking_count')->default(1); // Track number of bookings
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('appointment_slots');
    }
};
