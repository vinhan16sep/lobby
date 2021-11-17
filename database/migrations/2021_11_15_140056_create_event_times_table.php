<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_times', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('event_day_id')->length(11)->unsigned(); 
            $table->string('from');
            $table->string('to');
            $table->timestamp('created_at')->useCurrent();
            $table->string('created_by');
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
            $table->string('updated_by');
            $table->tinyInteger('is_active')->length(1)->default('1');
            $table->tinyInteger('is_deleted')->length(1)->default('0');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('event_times');
    }
}
