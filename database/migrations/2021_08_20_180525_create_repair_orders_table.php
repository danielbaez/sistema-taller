<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('receiving_user')->unsigned();
            $table->bigInteger('assigned_user')->unsigned();
            $table->bigInteger('branch_id')->unsigned();
            $table->bigInteger('client_id')->unsigned();
            $table->dateTime('promised_date');

            $table->timestamps();

            $table->foreign('receiving_user')->references('id')->on('users');
            $table->foreign('assigned_user')->references('id')->on('users');
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('client_id')->references('id')->on('clients');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repair_orders');
    }
}
