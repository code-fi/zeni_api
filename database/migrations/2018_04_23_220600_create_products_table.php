<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',100)->unique();
            $table->double('price',4, 2)->index();
            $table->string('extras',1000)->nullable();
            $table->mediumText('description');
            $table->string('status', 50)->default('unverified');
            $table->string('slug');     
            $table->float('rating')->default(0);
            $table->timestamp('added_on');
            $table->timestamp('exipres_on')->nullable();
            $table->unsignedTinyInteger('category_id');
            $table->unsignedBigInteger('store_id');
            // $table->unsignedTinyInteger('city_id');
            $table->foreign('store_id')->references('id')->on('stores')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('product_categories')->onDelete('cascade');
            // $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
