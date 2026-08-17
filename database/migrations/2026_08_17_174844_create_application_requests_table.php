<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('application_requests', function (Blueprint $table) {
            $table->id();

            $table->string('reference_code')->unique();

            $table->string('name');
            $table->string('email');
            $table->string('phone')->nullable();

            $table->string('organization');
            $table->string('unit');

            $table->string('subject');
            $table->text('statement');
            $table->text('request_text');

            $table->string('status')->default('pending');
            $table->string('category')->nullable();
            $table->string('priority')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('application_requests');
    }
};