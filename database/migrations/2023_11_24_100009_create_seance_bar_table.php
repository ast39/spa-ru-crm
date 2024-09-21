<?php

use App\Http\Enums\PayType;
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
        Schema::create('seance_bar', function (Blueprint $table) {

            $table->id('record_id')
                ->comment('ID записи');

            $table->unsignedBigInteger('shift_id')
                ->comment('ID смены');

            $table->unsignedBigInteger('seance_id')
                ->nullable()
                ->default(null)
                ->comment('ID сеанса');

            $table->unsignedBigInteger('item_id')
                ->comment('ID товара');

            $table->unsignedBigInteger('admin_id')
                ->comment('ID администратора');

            $table->unsignedFloat('amount')
                ->default(1)
                ->comment('Количество');

            $table->integer('sale')
                ->nullable()
                ->default(0)
                ->comment('Скидка в %');

            $table->unsignedTinyInteger('gift')
                ->nullable()
                ->default(0)
                ->comment('Подарок от заведения');

            $table->tinyInteger('pay_type')
                ->default(PayType::Cash->value)
                ->comment('Тип оплаты');

            $table->string('guest')
                ->nullable()
                ->default(null)
                ->comment('Имя гостя');

            $table->unsignedDecimal('admin_percent')
                ->default(0)
                ->comment('Процент администратора');

            $table->text('note')
                ->nullable()
                ->default(null)
                ->comment('Заметки администратора');

            $table->timestamps();

            $table->comment('Позиции товаров');

            $table->foreign('shift_id', 'seance_bar_shift_key')
                ->references('shift_id')
                ->on('shifts')
                ->onDelete('cascade');

            $table->foreign('seance_id', 'seance_bar_seance_key')
                ->references('seance_id')
                ->on('seance_programs')
                ->onDelete('cascade');

            $table->foreign('item_id', 'seance_bar_bar_key')
                ->references('item_id')
                ->on('bar')
                ->onDelete('cascade');

            $table->foreign('admin_id', 'seance_bar_admin_key')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('additional_items', function(Blueprint $table) {
            $table->dropForeign('seance_bar_shift_key');
            $table->dropForeign('seance_bar_seance_key');
            $table->dropForeign('seance_bar_bar_key');
            $table->dropForeign('seance_bar_admin_key');
        });

        Schema::dropIfExists('additional_items');
    }
};
