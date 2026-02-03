<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stream_type', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->bigInteger('amount');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stream_type');
    }
};
