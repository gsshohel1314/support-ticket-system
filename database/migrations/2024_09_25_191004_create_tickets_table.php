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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sender_id')->constrained('users');
            $table->string('sender_type');
            $table->foreignId('receiver_id')->constrained('users');
            $table->string('receiver_type');
            $table->foreignId('ticket_category_id')->nullable();
            $table->string('ticket_id');
            $table->string('subject');
            $table->enum('status', ['ongoing', 'pending', 'rejected', 'completed'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high'])->default('low');
            $table->longText('description')->nullable();
            $table->string('files')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
