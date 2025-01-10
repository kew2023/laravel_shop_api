<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id(); # Ссылка
            $table->dateTime('date'); # Дата
            $table->boolean('is_processed')->default(false); # Проведен
            $table->decimal('total', 15, 2)->default(0); # Сумма
            $table->string('payment_status', 36)->default('НеОплачен'); # СтатусОплаты
            $table->string('status', 36)->default('4454a860-1b1e-4020-83c4-beaede97e3ec'); # Состояние 
            $table->foreign('status')->references('guid')->on('document_statuses');
            $table->string('delivery_method', 36); # Способ доставки
            $table->dateTime('delivery_date'); # Дата доставки
            $table->string('delivery_address', 0)->nullable(); # ПунктРазгрузки
            $table->string('delivery_company', 0)->nullable(); # Транспортная компания
            $table->string('contact_name', 0)->nullable(); # Контактное лицо
            $table->string('contact_phone', 255)->nullable(); # Контактный телефон
            $table->string('website_comment', 0)->nullable(); # Комментарий с сайта
            $table->string('website_comment_for_client', 0)->nullable(); # КомментарийДляКлиента
            $table->dateTime('latest_update_by_client')->default(now()); # ПоследнееОбновлениеКлиентом
            $table->string('payment_type', 36)->default('Наличная'); # Способ оплаты
            $table->boolean('is_delivery_today'); # ДоставкаСегодня
            $table->bigInteger('created_by'); # Пользователь
            $table->foreign('created_by')->references('id')->on('users');
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
        Schema::dropIfExists('orders');
    }
}
