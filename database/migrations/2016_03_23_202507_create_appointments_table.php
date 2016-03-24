<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('appointment_type_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('organisation_id');
            $table->boolean('is_elected')->nullable();
            $table->dateTime('elected_at')->nullable();
            $table->dateTime('active_from')->nullable();
            $table->dateTime('active_to')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('appointments');
    }
}
