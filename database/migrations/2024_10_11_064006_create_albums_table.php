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
        //TODO: 
        /**
         *  Make the remote_id nullable and remove cascadeOnDelete 
         *  to keep the album when the remote is de-associated with the album
         */
        Schema::create('albums', function (Blueprint $table) {
            $table->id();
            $table->foreignId('remote_id')->nullable()->constrained();
            $table->foreignId('venue_id')->constrained();
            $table->timestamp('date_add')->useCurrent();
            $table->timestamp('date_over')->nullable();
            $table->timestamp('date_upd')->nullable();
            $table->enum('status', ['live', 'longterm']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('albums');
    }
};
