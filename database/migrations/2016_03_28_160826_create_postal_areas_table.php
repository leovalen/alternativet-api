<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostalAreasTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('postal_areas', function(Blueprint $table)
        {
            $table->char('postal_code', 4)->primary();
            $table->string('postal_area');
            $table->char('municipality_code', 4);
            $table->string('municipality_name');
            $table->char('category', 1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('postal_areas');
    }
}
