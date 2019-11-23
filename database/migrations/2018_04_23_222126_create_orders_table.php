<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->double('price_per_item',5,2);
            $table->double('amount',5,2);
            $table->unsignedTinyInteger('quantity');
            $table->string('status', 15)->default('pending')->index();
            $table->timestamp('placed_on')->index();
            $table->timestamp('expires_on')->nullable()->index();
            $table->string('customer_name',100);
            $table->string('customer_phone',20);
            $table->string('customer_address',100);
            $table->text('customer_remarks')->nullable();
            $table->unsignedBigInteger('product_id');
            $table->unsignedTinyInteger('payment_method');
            
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            // $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('payment_method')->references('id')->on('payment_methods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
