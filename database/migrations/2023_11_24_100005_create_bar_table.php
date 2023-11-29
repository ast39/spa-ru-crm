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
        Schema::create('bar', function (Blueprint $table) {

            $table->id('item_id');

            $table->string('title')
                ->comment('Название');

            $table->string('portion')
                ->comment('Порция');

            $table->unsignedFloat('price')
                ->comment('Цена');

            $table->integer('stock')
                ->nullable()
                ->default(0)
                ->comment('Остаток');

            $table->text('note')
                ->nullable()
                ->default(null)
                ->comment('Заметки о напитке');

            $table->unsignedTinyInteger('status')
                ->default(SoftStatus::On->value)
                ->comment('Статус напитка');

            $table->timestamps();

            $table->comment('Бар');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bar');
    }
};
