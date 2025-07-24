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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->text('description');
            $table->string('type')->default('ticket');
            $table->string('image')->nullable();
            $table->decimal('price', 14, 2);
            $table->integer('quantity')->nullable();
            $table->integer('min_per_order')->nullable();
            $table->integer('max_per_order')->nullable();
            $table->dateTimeTz('sale_start_date');
            $table->dateTimeTz('sale_end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
