<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank', function (Blueprint $table) {
            $table->id();
            $table->string('namaBank');
            $table->string('noRekening');
            $table->string('namaPemilik');
            $table->boolean('statusAktif')->default(true);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bank');
    }
};
