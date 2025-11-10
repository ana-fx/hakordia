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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 16)->unique();
            $table->string('full_name');
            $table->string('whatsapp_number');
            $table->string('email')->unique();
            $table->text('address');
            $table->date('date_of_birth');
            $table->string('city');
            $table->enum('jersey_size', ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL', 'All Size']);
            $table->enum('blood_type', ['A', 'B', 'AB', 'O'])->nullable();
            $table->string('emergency_contact_number');
            $table->text('medical_conditions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
