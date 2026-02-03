<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcement', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('deskripsi')->nullable();
            $table->text('isi');
            $table->string('namaFile')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });

        Schema::create('merchandise', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });

        Schema::create('verify', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idUser')->constrained('users')->onDelete('cascade');
            $table->string('token');
            $table->boolean('verify')->default(false);
            $table->integer('resend_count')->default(0);
            $table->timestamp('last_resend_at')->nullable();
        });

        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('system_name')->default('Membership App');
            $table->string('logo')->nullable();
            $table->string('webbg')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('announcement');
        Schema::dropIfExists('merchandise');
        Schema::dropIfExists('verify');
        Schema::dropIfExists('settings');
    }
};
