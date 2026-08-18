<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {   // Create a sequence to generate unique application request reference numbers.
        DB::statement("
            CREATE SEQUENCE application_request_reference_seq
            START WITH 1
            INCREMENT BY 1
        ");
        
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

    // Remove the reference sequence after dropping the dependent table.
    DB::statement('DROP SEQUENCE IF EXISTS application_request_reference_seq');
}
};