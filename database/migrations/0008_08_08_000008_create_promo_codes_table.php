<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained();
            $table->string('name');
            $table->string('code');
            $table->integer('discount');
            $table->enum('type', ['percentage', 'fixed'])->default('percentage');
            $table->integer('max_uses')->default(1);
            $table->boolean('is_ticket')->default(false);
            $table->boolean('is_merchandise')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_codes');
    }
};
