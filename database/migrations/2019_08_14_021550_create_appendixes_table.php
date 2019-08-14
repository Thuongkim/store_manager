<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppendixesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('appendixes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('contract_id')->unsigned();
            $table->date('sign_date');
            $table->string('duration');
            $table->boolean('renewed');
            $table->string('value')->nullable();
            $table->boolean('payment');
            $table->date('payment_date');
            $table->text('note')->nullable();

            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');
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
        Schema::dropIfExists('appendixes');
    }
}
