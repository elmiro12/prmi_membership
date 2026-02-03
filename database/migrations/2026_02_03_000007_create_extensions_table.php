<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('extensions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idMembership')->nullable()->constrained('membership')->onDelete('cascade');
            $table->foreignId('idStreamMembership')->nullable()->constrained('stream_membership')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('extensions');
    }
};
