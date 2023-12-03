<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('z_reports', function (Blueprint $table) {

            $table->id('report_id');

            $table->unsignedBigInteger('shift_id')
                ->comment('Отчет за смену');

            $table->unsignedInteger('clients')
                ->nullable()
                ->default(0)
                ->comment('Кол-во гостей');

            $table->unsignedFloat('cash_profit')
                ->nullable()
                ->default(0)
                ->comment('Выручка наличкой');

            $table->unsignedFloat('card_profit')
                ->nullable()
                ->default(0)
                ->comment('Выручка безналом');

            $table->unsignedFloat('phone_profit')
                ->nullable()
                ->default(0)
                ->comment('Выручка переводом');

            $table->unsignedFloat('programs_profit')
                ->nullable()
                ->default(0)
                ->comment('Выручка с программ');

            $table->unsignedFloat('services_profit')
                ->nullable()
                ->default(0)
                ->comment('Выручка с услуг');

            $table->unsignedFloat('bar_profit')
                ->nullable()
                ->default(0)
                ->comment('Выручка с бара');

            $table->unsignedFloat('admin_profit')
                ->nullable()
                ->default(0)
                ->comment('Зарплата администратору');

            $table->unsignedFloat('masters_profit')
                ->nullable()
                ->default(0)
                ->comment('Зарплата мастерам');

            $table->unsignedFloat('sale_sum')
                ->nullable()
                ->default(0)
                ->comment('Скидки гостям');

            $table->unsignedFloat('expenses')
                ->nullable()
                ->default(0)
                ->comment('Расходы смены');

            $table->unsignedFloat('owner_profit')
                ->nullable()
                ->default(0)
                ->comment('Доход заведения');

            $table->unsignedFloat('stock')
                ->nullable()
                ->default(0)
                ->comment('Остаток в кассе');

            $table->text('additional')
                ->nullable()
                ->default(null)
                ->comment('Примечание к смене');

            $table->timestamps();

            $table->comment('Z отчеты');

            $table->foreign('shift_id', 'report_shift_key')
                ->references('shift_id')
                ->on('shifts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('z_reports');

        Schema::table('z_reports', function(Blueprint $table) {
            $table->dropForeign('item_add_admin_key');
            $table->dropForeign('item_add_item_key');
        });
    }
};
