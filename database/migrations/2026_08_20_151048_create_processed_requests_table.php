<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Create the table that stores the ETL-processed application requests.
        Schema::create('processed_requests', function (Blueprint $table) {
            $table->id();

            // Reference code of the original application request.
            $table->string('reference_code')->unique();

            // Destination information from the original request.
            $table->string('organization');
            $table->string('unit');

            // Original subject of the application request.
            $table->string('subject');

            // Clean and normalized text prepared for data analysis and NLP.
            $table->text('normalized_text');

            // Current processing status of the original request.
            $table->string('status');

            // Classification fields that can be populated by later processing steps.
            $table->string('category')->nullable();
            $table->string('priority')->nullable();

            // Timestamps used to track the source record and the ETL process.
            $table->timestamp('source_created_at');
            $table->timestamp('processed_at');

            // Timestamps for the processed record itself.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove the processed requests table when rolling back the migration.
        Schema::dropIfExists('processed_requests');
    }
};