<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->nullable();
            $table->foreignId('idBank')->constrained('bank');
            $table->foreignId('idExtension')->constrained('extensions')->onDelete('cascade');
            $table->string('bukti'); // photo path
            $table->boolean('status')->default(false); // 0: pending/rejected? 1: verified?
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment');
    }
};
