<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders_items', function (Blueprint $table) {

            $table->decimal('price', 15, 2)->nullable()->change(); # Цена
            $table->decimal('discount', 5, 2)->default(0)->change(); # ПроцентСкидки
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders_items', function (Blueprint $table) {
            //
            $table->decimal('price', 15, 2)->nullable(false)->change(); # Цена
            $table->decimal('discount', 5, 2)->change(); # ПроцентСкидки
        });
    }
}
