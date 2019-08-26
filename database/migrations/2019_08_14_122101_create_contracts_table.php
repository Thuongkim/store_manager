<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contracts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('number');
            $table->date('sign_day');
            $table->integer('customer_id')->unsigned();
            $table->integer('categorize_id')->unsigned();
            $table->string('duration');
            $table->boolean('renewed')->nullable();
            $table->string('value')->nullable();
            $table->boolean('payment');
            $table->dateTime('day_payment');
            $table->text('note')->nullable();
            $table->integer('sale_id')->unsigned();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('categorize_id')->references('id')->on('categorizes');
            $table->foreign('sale_id')->references('id')->on('sales');

        });
    }


    public function down()
    {
        Schema::dropIfExists('contracts');
    }
}
