<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->string('email', 50)->unique();
            $table->string('phone',15)->unique();
            $table->string('password');
            $table->string('location')->nullable();
            $table->ipAddress('ip_address')->nullable();
            // $table->string('profile_image', 100);
            $table->unsignedTinyInteger('city_id')->default(1);       
            $table->string('account_type', 50)->default('basic');
            $table->string('account_status')->default('unverified');
            $table->unsignedTinyInteger('post_limit')->default(5);
            $table->timestamp('next_post_date')->nullable();
            // $table->string('app_id')->nullable();
            // $table->string('client_id')->nullable();
            // $table->timestamp('client_expires')->nullable();
            $table->timestamp('joined')->nullable();     
            $table->timestamp('last_active')->nullable();
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
