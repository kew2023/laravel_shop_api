<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class NullableOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {

            $table->dateTime('date')->default(now())->change(); # Дата
            $table->string('delivery_method', 36)->nullable()->change(); # Способ доставки
            $table->dateTime('delivery_date')->nullable()->change(); # Дата доставки
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dateTime('date')->change(); # Дата
            $table->string('delivery_method', 36)->nullable(false)->change(); # Способ доставки
            $table->dateTime('delivery_date')->nullable(false)->change(); # Дата доставки
        });
    }
}
