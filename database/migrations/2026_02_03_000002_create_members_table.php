<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('idUser')->constrained('users')->onDelete('cascade');
            $table->string('fullname');
            $table->date('dob');
            $table->string('gender');
            $table->string('contact_number');
            $table->text('address');
            $table->string('instagram')->nullable();
            $table->string('postcode')->nullable();
            $table->string('occupation')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
