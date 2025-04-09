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
            $table->boolean('time_8_00_8_50')->default(false);
            $table->boolean('time_9_00_9_50')->default(false);
            $table->boolean('time_10_00_10_50')->default(false);
            $table->boolean('time_11_00_11_50')->default(false);
            $table->boolean('time_12_00_12_50')->default(false);
            $table->boolean('time_13_00_13_50')->default(false);
            $table->boolean('time_14_00_14_50')->default(false);
            $table->boolean('time_15_00_15_50')->default(false);
            $table->boolean('time_16_00_16_50')->default(false);
            $table->boolean('time_17_00_17_50')->default(false);
        });
    }
    
    public function down()
    {
        Schema::table('schedules', function (Blueprint $table) {
            $table->dropColumn([
                'time_8_00_8_50', 'time_9_00_9_50', 'time_10_00_10_50', 
                'time_11_00_11_50', 'time_12_00_12_50', 'time_13_00_13_50', 
                'time_14_00_14_50', 'time_15_00_15_50', 'time_16_00_16_50', 'time_17_00_17_50'
            ]);
        });
    }
    
};
