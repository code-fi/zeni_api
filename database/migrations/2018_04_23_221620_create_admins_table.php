<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('username',100)->unique();
            $table->string('name', 100);
            $table->string('email', 50)->unique();
            $table->string('password');
            
            $table->string('role')->default('super-admin');
            
            $table->ipAddress('access_ip_address')->nullable();
            $table->string('access_user_agent')->nullable();
            $table->rememberToken();
            $table->timestamp('last_active')->nullable();            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
