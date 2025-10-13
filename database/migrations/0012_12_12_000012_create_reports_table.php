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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('event_id')->nullable()->constrained()->cascadeOnDelete();

            $table->string('reason')->nullable();
            $table->longText('description')->nullable();

            // Respon admin
            $table->longText('admin_reply')->nullable();
            $table->timestamp('admin_replied_at')->nullable();

            // Respon super admin
            $table->longText('super_admin_reply')->nullable();
            $table->timestamp('super_admin_replied_at')->nullable();

            $table->enum('status', [
                'unread',
                'read',
                'replied',
                'escalated',
                'resolved',
                'dismissed',
            ])->default('unread');

            $table->timestamp('escalated_at')->nullable();

            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
