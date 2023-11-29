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
        Schema::create('users', function (Blueprint $table) {

            $table->id()
                ->comment('ID пользователя');

            $table->string('name')
                ->comment('Имя пользоватля');

            $table->string('login')
                ->unique()
                ->comment('Логин пользоватля');

            $table->string('password')
                ->comment('Пароль пользоватля');

            $table->rememberToken()
                ->comment('Токен авторизации');

            $table->text('note')
                ->nullable()
                ->default(null)
                ->comment('Заметки о пользователе');

            $table->timestamps();

            $table->comment('Пользователи');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
