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
        Schema::create('services', function (Blueprint $table) {

            $table->id('service_id')
                ->comment('ID услуги');

            $table->string('title')
                ->comment('Название услуги');

            $table->unsignedFloat('price')
                ->comment('Цена услуги');

            $table->text('note')
                ->nullable()
                ->default(null)
                ->comment('Заметки об услуге');

            $table->unsignedTinyInteger('status')
                ->default(SoftStatus::On->value)
                ->comment('Статус услуги');

            $table->timestamps();

            $table->comment('Справочник товаров');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
