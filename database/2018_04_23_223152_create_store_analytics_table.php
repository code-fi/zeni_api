<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStoreAnalyticsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('store_analytics', function (Blueprint $table) {
            $table->unsignedBigInteger('store_id')->unique();
            $table->unsignedTinyInteger('visit_today')->default(0);
            $table->unsignedTinyInteger('visit_today')->default(0);
            $table->unsignedTinyInteger('visit_today')->default(0);
            $table->unsignedTinyInteger('visit_today')->default(0);
            $table->timestamp('last_updated');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('store_analytics');
    }
}
