<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 100);
            $table->string('position', 100);
            $table->string('phone', 30);
            $table->string('email', 120)->unique();
            $table->string('photo', 255);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
