<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders_items', function (Blueprint $table) {
            $table->bigInteger('order_id'); # Ссылка на заказ
            $table->foreign('order_id')->references('id')->on('orders');
            $table->decimal('amount', 15, 3); # Количество
            $table->string('nomenclature_guid', 36); # Номенклатура
            $table->foreign('nomenclature_guid')->references('guid')->on('nomenclatures');
            $table->decimal('price', 15, 2); # Цена
            $table->decimal('discount', 5, 2); # ПроцентСкидки

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
        Schema::dropIfExists('orders_items');
    }
}
