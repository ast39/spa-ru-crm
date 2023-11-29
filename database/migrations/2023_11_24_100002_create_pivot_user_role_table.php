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
        Schema::create('pivot_user_role', function (Blueprint $table) {

            $table->id()
                ->comment('ID записи');

            $table->unsignedBigInteger('user_id')
                ->index()
                ->comment('ID пользователя');

            $table->unsignedBigInteger('role_id')
                ->index()
                ->comment('ID роли');

            $table->unsignedBigInteger('percent_program')
                ->nullable()
                ->default(0)
                ->comment('Процент с программы');

            $table->unsignedBigInteger('percent_service')
                ->nullable()
                ->default(0)
                ->comment('Процент с услуг');

            $table->unsignedBigInteger('percent_bar')
                ->nullable()
                ->default(0)
                ->comment('Процент с бара');

            $table->unique(['user_id', 'role_id']);

            $table->comment('Соотвествия ролей и пользователей');

            $table->foreign('user_id', 'user_role_user_key')
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
        Schema::dropIfExists('pivot_user_role');
    }
};
