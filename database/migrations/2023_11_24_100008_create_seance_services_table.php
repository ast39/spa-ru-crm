<?php

use App\Http\Enums\PayType;
use App\Http\Enums\SeanceStatus;
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
        Schema::create('seance_services', function (Blueprint $table) {

            $table->id('record_id')
                ->comment('ID записи');

            $table->unsignedBigInteger('shift_id')
                ->comment('ID смены');

            $table->unsignedBigInteger('seance_id')
                ->nullable()
                ->default(null)
                ->comment('ID сеанса');

            $table->unsignedBigInteger('service_id')
                ->comment('ID товара');

            $table->unsignedBigInteger('admin_id')
                ->comment('ID администратора');

            $table->unsignedBigInteger('master_id')
                ->nullable()
                ->default(null)
                ->comment('ID администратора');

            $table->unsignedBigInteger('cover_master_id')
                ->nullable()
                ->default(null)
                ->comment('ID второго мастера');

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

            $table->unsignedDecimal('master_percent')
                ->default(0)
                ->comment('Процент основного мастера');

            $table->unsignedDecimal('cover_master_percent')
                ->default(0)
                ->comment('Процент второго мастера');

            $table->text('note')
                ->nullable()
                ->default(null)
                ->comment('Заметки администратора');

            $table->unsignedTinyInteger('status')
                ->default(SeanceStatus::Completed->value)
                ->comment('Статус услуги');

            $table->timestamps();

            $table->comment('Доп. услуги');

            $table->foreign('shift_id', 'seance_service_shift_key')
                ->references('shift_id')
                ->on('shifts')
                ->onDelete('cascade');

            $table->foreign('seance_id', 'seance_service_seance_key')
                ->references('seance_id')
                ->on('seance_programs')
                ->onDelete('cascade');

            $table->foreign('service_id', 'seance_service_service_key')
                ->references('service_id')
                ->on('services')
                ->onDelete('cascade');

            $table->foreign('admin_id', 'service_add_admin_key')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('master_id', 'service_add_master_key')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('master_id', 'seance_service_cover_master_key')
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
        Schema::table('seance_services', function(Blueprint $table) {
            $table->dropForeign('seance_service_shift_key');
            $table->dropForeign('seance_service_seance_key');
            $table->dropForeign('seance_service_service_key');
            $table->dropForeign('seance_service_admin_key');
            $table->dropForeign('seance_service_master_key');
            $table->dropForeign('seance_service_cover_master_key');
        });

        Schema::dropIfExists('additional_items');
    }
};
