<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('missing_person_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('applicant_user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('full_name');
            $table->date('birth_date')->nullable();
            $table->string('last_seen_place');
            $table->text('description');
            $table->string('contacts');
            $table->enum('status', ['new', 'in_review', 'approved', 'rejected'])->default('new');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('missing_person_requests');
    }
};
