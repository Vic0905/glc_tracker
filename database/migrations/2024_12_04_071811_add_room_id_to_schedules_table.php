<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->unsignedBigInteger('room_id')->nullable(); // Add room_id column
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('set null'); // Foreign key constraint
        });
    }
    
    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropForeign(['room_id']); // Drop foreign key constraint
            $table->dropColumn('room_id'); // Drop the room_id column
        });
    }
    
};
