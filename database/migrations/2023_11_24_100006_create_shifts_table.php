<?php

use App\Http\Enums\SoftStatus;
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
        Schema::create('shifts', function (Blueprint $table) {

            $table->id('shift_id');

            $table->date('title')
                ->comment('Сутки');

            $table->unsignedBigInteger('opened_admin_id')
                ->comment('Открывший смену администратор');

            $table->unsignedBigInteger('closed_admin_id')
                ->nullable()
                ->default(null)
                ->comment('Закрывший смену администратор');

            $table->timestamp('opened_time')
                ->comment('Время открытия смены');

            $table->timestamp('closed_time')
                ->nullable()
                ->default(null)
                ->comment('Время закрытия смены');

            $table->text('note')
                ->nullable()
                ->default(null)
                ->comment('Заметки к смене');

            $table->unsignedTinyInteger('status')
                ->default(SoftStatus::Off->value)
                ->comment('Статус смены');

            $table->timestamps();

            $table->comment('Смены');

            $table->foreign('opened_admin_id', 'shift_opened_admin_key')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('closed_admin_id', 'shift_closed_admin_key')
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
        Schema::dropIfExists('shifts');

        Schema::table('shifts', function(Blueprint $table) {
            $table->dropForeign('shift_opened_admin_key');
            $table->dropForeign('shift_closed_admin_key');
        });
    }
};
