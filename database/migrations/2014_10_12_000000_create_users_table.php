<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('password', 255);
            $table->char('active', 1)->default('Y');
            $table->string('name', 50);
            $table->string('last_name', 50);
            $table->string('second_name', 50)->nullable();;
            $table->string('email', 255)->unique();
            $table->dateTime('last_login')->default(now());
            $table->softDeletes();
            $table->string('role', 50)->default('customer');
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
        Schema::dropIfExists('users');
    }
}
