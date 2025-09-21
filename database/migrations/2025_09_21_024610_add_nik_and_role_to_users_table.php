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
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom setelah kolom 'name'
            $table->after('name', function ($table) {
                $table->string('nik')->unique()->nullable();
                $table->enum('role', ['masyarakat', 'petugas', 'admin'])->default('masyarakat');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['nik', 'role']);
        });
    }
};
