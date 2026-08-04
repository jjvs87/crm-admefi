<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qualifications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lead_id')->unique()->constrained('leads')->cascadeOnDelete();
            $table->boolean('has_company')->nullable();
            $table->integer('employees')->nullable();
            $table->boolean('has_inhouse_lawyer')->nullable();
            $table->boolean('has_insurance')->nullable();
            $table->boolean('has_lawsuits')->nullable();
            $table->boolean('has_overdue_debt')->nullable();
            $table->boolean('has_branches')->nullable();
            $table->string('decision_maker')->nullable();
            $table->decimal('revenue', 12, 2)->nullable();
            $table->string('level')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qualifications');
    }
};