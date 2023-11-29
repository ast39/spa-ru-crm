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
        Schema::create('seance_programs', function (Blueprint $table) {

            $table->id('seance_id')
                ->comment('ID записи');

            $table->unsignedBigInteger('shift_id')
                ->comment('ID смены');

            $table->unsignedBigInteger('admin_id')
                ->comment('ID администратора');

            $table->unsignedBigInteger('master_id')
                ->comment('ID мастера');

            $table->unsignedBigInteger('program_id')
                ->comment('ID программы');

            $table->string('guest')
                ->nullable()
                ->default(null)
                ->comment('Имя гостя');

            $table->string('from')
                ->nullable()
                ->default(null)
                ->comment('Откуда узнал');

            $table->timestamp('open_time')
                ->nullable()
                ->default(null)
                ->comment('Время начала сеанса');

            $table->timestamp('close_time')
                ->nullable()
                ->default(null)
                ->comment('Время окончания сеанса');

            $table->integer('handle_price')
                ->nullable()
                ->default(null)
                ->comment('Корректировка стоимости сеанса');

            $table->integer('sale')
                ->nullable()
                ->default(0)
                ->comment('Скидка в %');

            $table->tinyInteger('pay_type')
                ->default(PayType::Cash->value)
                ->comment('Тип оплаты');

            $table->text('note')
                ->nullable()
                ->default(null)
                ->comment('Заметки администратора');

            $table->unsignedTinyInteger('status')
                ->default(SeanceStatus::Completed->value)
                ->comment('Статус сеанса');

            $table->timestamps();

            $table->comment('Сеансы');

            $table->foreign('program_id', 'seance_program_key')
                ->references('program_id')
                ->on('programs')
                ->onDelete('cascade');

            $table->foreign('admin_id', 'seance_admin_key')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('master_id', 'seance_master_key')
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
        Schema::dropIfExists('seances');

        Schema::table('seance_programs', function(Blueprint $table) {
            $table->dropForeign('seance_program_key');
            $table->dropForeign('seance_master_key');
        });
    }
};
