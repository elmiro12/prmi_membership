<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idMember')->constrained('members')->onDelete('cascade');
            $table->string('membership_number')->nullable();
            $table->date('reg_date');
            $table->foreignId('tipe_member')->constrained('membership_types')->onDelete('cascade');
            $table->boolean('exsist')->default(true);
            $table->date('expiry_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership');
    }
};
