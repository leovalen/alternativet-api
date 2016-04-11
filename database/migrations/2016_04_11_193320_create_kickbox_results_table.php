<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKickboxResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kickbox_results', function (Blueprint $table) {
            $table->increments('id');
            $table->string('result')->nullable()->index();
            $table->string('reason')->nullable();
            $table->boolean('role')->nullable();
            $table->boolean('free')->nullable();
            $table->boolean('disposable')->nullable();
            $table->boolean('accept_all')->nullable();
            $table->string('did_you_mean')->nullable();
            $table->float('sendex')->nullable();
            $table->string('email')->nullable()->index();
            $table->string('user')->nullable();
            $table->string('domain')->nullable();
            $table->boolean('success')->nullable();
            $table->string('message')->nullable();
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
        Schema::drop('kickbox_results');
    }
}
