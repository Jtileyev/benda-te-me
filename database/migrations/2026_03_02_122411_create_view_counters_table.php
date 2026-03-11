<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('view_counters', function (Blueprint $table) {
            $table->id();
            $table->string('page_key')->unique();
            $table->unsignedBigInteger('total_views')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('view_counters');
    }
};
