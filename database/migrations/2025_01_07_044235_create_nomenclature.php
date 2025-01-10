<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNomenclature extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nomenclatures', function (Blueprint $table) {
            $table->string('guid', 36)->primary();
            $table->string('code', 11); # Код
            $table->string('name', 100); # Наименование
            $table->string('full_name', 0); # НаименованиеПолное
            $table->string('set_number', 25); # Артикул
            $table->string('brand_guid', 36); # Бренд
            $table->foreign('brand_guid')->references('guid')->on('brands');
            $table->decimal('price', 15, 2)->nullable(); # Цена
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
        Schema::dropIfExists('nomenclatures');
    }
}
