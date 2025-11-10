<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('checkouts', function (Blueprint $table) {
            $table->id();
            $table->uuid('unique_id')->unique();
            $table->string('order_number')->unique();
            $table->integer('total_amount');
            $table->integer('total_participants');
            $table->enum('status', ['pending', 'waiting', 'paid', 'expired', 'verified'])->default('pending');
            $table->enum('status_verifikasi', ['pending', 'verified'])->default('pending');
            $table->string('payment_proof')->nullable();
            $table->timestamp('payment_deadline');
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('checkout_participants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('checkout_id')->constrained()->onDelete('cascade');
            $table->string('nik');
            $table->string('full_name');
            $table->string('whatsapp_number');
            $table->string('email');
            $table->text('address');
            $table->date('date_of_birth');
            $table->string('city');
            $table->string('jersey_size');
            $table->string('blood_type');
            $table->string('emergency_contact_number');
            $table->text('medical_conditions')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('checkout_participants');
        Schema::dropIfExists('checkouts');
    }
};
