<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stream_membership', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->nullable();
            $table->foreignId('idMember')->constrained('members')->onDelete('cascade');
            $table->foreignId('idType')->constrained('stream_type')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stream_membership');
    }
};
