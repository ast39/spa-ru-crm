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
        Schema::create('stock', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('item_id')
                ->comment('ID товара');

            $table->unsignedBigInteger('shift_id')
                ->nullable()
                ->default(null)
                ->comment('ID смены');

            $table->unsignedBigInteger('admin_id')
                ->comment('ID администратора');

            $table->integer('value')
                ->comment('Кол-во');

            $table->text('note')
                ->nullable()
                ->default(null)
                ->comment('Заметки к операции');

            $table->timestamps();

            $table->comment('Складской учет');

            $table->foreign('item_id', 'stock_item_key')
                ->references('item_id')
                ->on('bar');

            $table->foreign('admin_id', 'stock_admin_key')
                ->references('id')
                ->on('users');

            $table->foreign('shift_id', 'stock_shift_key')
                ->references('shift_id')
                ->on('shifts');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock');
    }
};
