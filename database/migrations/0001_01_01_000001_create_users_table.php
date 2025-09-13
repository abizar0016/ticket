<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Buat tabel users terlebih dahulu jika belum ada
        if (!Schema::hasTable('users')) {
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->foreignId('organization_id')->nullable()->unique()->constrained('organizations')->nullOnDelete();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->enum('role', ['superadmin', 'admin', 'customer'])->default('customer');
                $table->rememberToken();
                $table->timestampsTz();
            });
        }

        // Tambahkan kolom baru
        Schema::table('users', function (Blueprint $table) {
            $columnsToAdd = [
                'provider' => ['type' => 'string', 'nullable' => true, 'after' => 'password'],
                'provider_id' => ['type' => 'string', 'nullable' => true, 'after' => 'provider'],
                'profile_picture' => ['type' => 'string', 'nullable' => true, 'after' => 'provider_id'],
                'last_login_at' => ['type' => 'timestamp', 'nullable' => true, 'after' => 'profile_picture'],
                'last_login_ip' => ['type' => 'string', 'nullable' => true, 'after' => 'last_login_at'],
                'login_count' => ['type' => 'integer', 'default' => 0, 'after' => 'last_login_ip']
            ];

            foreach ($columnsToAdd as $column => $options) {
                if (!Schema::hasColumn('users', $column)) {
                    $table->{$options['type']}($column)
                        ->nullable($options['nullable'] ?? false)
                        ->default($options['default'] ?? null)
                        ->after($options['after'] ?? null);
                }
            }
        });

        // Tabel pendukung
        if (!Schema::hasTable('password_reset_tokens')) {
            Schema::create('password_reset_tokens', function (Blueprint $table) {
                $table->string('email')->primary();
                $table->string('token');
                $table->timestamp('created_at')->nullable();
            });
        }

        if (!Schema::hasTable('sessions')) {
            Schema::create('sessions', function (Blueprint $table) {
                $table->string('id')->primary();
                $table->foreignId('user_id')->nullable()->index();
                $table->string('ip_address', 45)->nullable();
                $table->text('user_agent')->nullable();
                $table->longText('payload');
                $table->integer('last_activity')->index();
            });
        }
    }

    public function down()
    {
        // Jangan drop tabel users jika sudah ada data penting
        Schema::table('users', function (Blueprint $table) {
            $columns = [
                'provider',
                'provider_id',
                'profile_picture',
                'last_login_at',
                'last_login_ip',
                'login_count'
            ];

            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};