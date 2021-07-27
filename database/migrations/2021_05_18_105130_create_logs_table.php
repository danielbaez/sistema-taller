<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('profile_id')->nullable()->unsigned();
            $table->bigInteger('branch_id')->nullable()->unsigned();
            $table->text('description');
            $table->tinyInteger('status');
            $table->dateTime('created_at');

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('profile_id')->nullable()->references('id')->on('profiles');
            $table->foreign('branch_id')->nullable()->references('id')->on('branches');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('logs');
    }
}
