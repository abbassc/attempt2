<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone', 20);
            $table->enum('type', ['money', 'food', 'clothes']);
            $table->text('description');
            $table->string('occasion')->nullable();
            $table->string('location');
            $table->date('date');
            $table->string('time', 20);
            $table->string('status')->default('pending');
            $table->foreignId('donor_id')->nullable()->constrained('users');
            $table->foreignId('volunteer_id')->nullable()->constrained('users');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
}; 