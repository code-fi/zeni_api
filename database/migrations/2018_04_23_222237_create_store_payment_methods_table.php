<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStorePaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_payment_methods', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedBigInteger('store_id');
            $table->unsignedTinyInteger('method_id');
            $table->string('details');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->foreign('method_id')->references('id')->on('payment_methods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_payment_methods');
    }
}
