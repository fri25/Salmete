<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['participant', 'exposant'])->default('participant');
            $table->string('full_name');
            $table->string('organization')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->string('profile')->nullable();
            $table->text('message')->nullable();
            $table->enum('status', ['nouveau', 'en_cours', 'accepte', 'refuse'])->default('nouveau');
            $table->text('admin_note')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
