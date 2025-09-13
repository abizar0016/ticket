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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_code')->unique();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('organizations_id')->nullable()->constrained('organizations')->cascadeOnDelete();
            $table->foreignId('categories_id')->nullable()->constrained('categories')->cascadeOnDelete();
            
            // Basic Information
            $table->string('title');
            $table->text('description');
            $table->dateTimeTz('start_date');
            $table->dateTimeTz('end_date');
            $table->string('timezone')->default('Asia/Jakarta');
            $table->string('event_image')->nullable();
            
            //Bank Information
            $table->string('bank_name')->nullable();
            $table->string('bank_account_number')->nullable();
            $table->string('bank_account_name')->nullable();
            
            // Status and timestamps
            $table->enum('status', ['draft', 'published'])->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
