<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('sponsor_offers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('audience')->nullable();
            $table->bigInteger('price')->default(0);
            $table->string('price_note')->nullable();
            $table->text('description')->nullable();
            $table->text('features')->nullable();
            $table->string('badge')->nullable();
            $table->integer('sort_order')->default(0);
            $table->boolean('is_visible')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sponsor_offers');
    }
};
