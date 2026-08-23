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
        Schema::create('request_reports', function (Blueprint $table) {
            // Primary key for the report.
            $table->id();

            // Date and time when the report was generated.
            $table->timestamp('generated_at');

            // Total number of processed requests included in the report.
            $table->unsignedInteger('total_requests');

            // Request statistics grouped by organization.
            $table->json('by_organization');

            // Request statistics grouped by status.
            $table->json('by_status');

            // Laravel timestamps: when the report was created and last updated.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_reports');
    }
};
