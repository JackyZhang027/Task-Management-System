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
        Schema::table('proposals', function($table) {
            $table->unsignedBigInteger('process_id')->nullable();
            $table->unsignedBigInteger('process_state_id')->nullable();
            $table->foreign('process_id')->references('id')->on('process_categories'); // Define the foreign key constraint
            $table->foreign('process_state_id')->references('id')->on('process_category_states'); // Define the foreign key constraint
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('proposals', function($table) {
            $table->dropColumn('process_id');
            $table->dropColumn('process_state_id');
        });
    }
};
