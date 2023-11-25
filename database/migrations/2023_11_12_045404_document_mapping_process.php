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
        Schema::table('document_mapping', function($table) {
            
            $table->unsignedBigInteger('process_id')->nullable();
            $table->foreign('process_id')->references('id')->on('process_categories'); // Define the foreign key constraint
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document_mapping', function($table) {
            $table->dropColumn('process_id');
        });
    
    }
};
