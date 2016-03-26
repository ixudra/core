<?php


use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCommandHistory extends Migration {

    public function up()
    {
        Schema::create('command_history', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('command', 256);
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->boolean('is_successful');
        });
    }

    public function down()
    {
        Schema::dropIfExists('command_history');
    }

}
