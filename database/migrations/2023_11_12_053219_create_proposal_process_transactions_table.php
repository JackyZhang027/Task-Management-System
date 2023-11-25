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
        Schema::create('proposal_process_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposal_id')->nullable();
            $table->unsignedBigInteger('service_id')->nullable(); 
            $table->unsignedBigInteger('services_mapping_id')->nullable(); 
            $table->boolean('is_checked')->default(false);
            $table->unsignedBigInteger('checked_by')->nullable();
            $table->timestamp('checked_date')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('checked_by')->references('id')->on('users'); 
            $table->foreign('proposal_id')->references('id')->on('proposals'); 
            $table->foreign('services_mapping_id')->references('id')->on('document_mapping');
            $table->foreign('service_id')->references('id')->on('services');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal_process_transactions');
    }
};
