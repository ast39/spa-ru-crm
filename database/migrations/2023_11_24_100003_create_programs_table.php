<?php

use App\Http\Enums\ProgramType;
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
        Schema::create('programs', function (Blueprint $table) {

            $table->id('program_id')
                ->comment('ID программы');

            $table->string('title')
                ->comment('Название программы');

            $table->unsignedTinyInteger('type')
                ->default(ProgramType::All->value)
                ->comment('Для кого программа');

            $table->unsignedInteger('period')
                ->comment('Продолжительность');

            $table->unsignedFloat('price')
                ->comment('Стоимость программы');

            $table->text('note')
                ->nullable()
                ->default(null)
                ->comment('Заметки о программе');

            $table->unsignedTinyInteger('status')
                ->default(SoftStatus::On->value)
                ->comment('Статус программы');

            $table->timestamps();

            $table->comment('Справочник программ');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
