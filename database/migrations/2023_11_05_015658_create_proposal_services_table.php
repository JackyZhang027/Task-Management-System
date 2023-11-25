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
        Schema::create('proposal_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('proposal_id')->unsigned();
            $table->unsignedBigInteger('service_id'); // Foreign key column
            $table->float("Fee");
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('service_id')->references('id')->on('services'); // Define the foreign key constraint
            $table->foreign('proposal_id')->references('id')->on('proposals')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proposal_services');
    }
};
