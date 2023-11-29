<?php

namespace Database\Seeders;

use App\Http\Enums\ProgramType;
use App\Models\Admin;
use App\Models\Program;
use Illuminate\Database\Seeder;

class Programs extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Program::create([
            'title'  => 'Премьера 60',
            'type'   => ProgramType::Man->value,
            'period' => 60,
            'price'  => 5500,
        ]);

        Program::create([
            'title'  => 'Премьера 90',
            'type'   => ProgramType::Man->value,
            'period' => 90,
            'price'  => 7500,
        ]);

        Program::create([
            'title'  => 'Королевский Релакс 60',
            'type'   => ProgramType::Man->value,
            'period' => 60,
            'price'  => 7300,
        ]);

        Program::create([
            'title'  => 'Королевский Релакс 90',
            'type'   => ProgramType::Man->value,
            'period' => 90,
            'price'  => 8900,
        ]);

        Program::create([
            'title'  => 'Эпизод',
            'type'   => ProgramType::Man->value,
            'period' => 30,
            'price'  => 3000,
        ]);

        Program::create([
            'title'  => 'Боди Релакс',
            'type'   => ProgramType::Man->value,
            'period' => 45,
            'price'  => 4000,
        ]);

        Program::create([
            'title'  => 'Рандеву',
            'type'   => ProgramType::Man->value,
            'period' => 90,
            'price'  => 14500,
        ]);

        Program::create([
            'title'  => 'Основной Инстинкт 60',
            'type'   => ProgramType::Man->value,
            'period' => 60,
            'price'  => 13800,
        ]);

        Program::create([
            'title'  => 'Основной Инстинкт 90',
            'type'   => ProgramType::Man->value,
            'period' => 90,
            'price'  => 18400,
        ]);

        Program::create([
            'title'  => 'Власть и Грация 60',
            'type'   => ProgramType::Man->value,
            'period' => 60,
            'price'  => 12000,
        ]);

        Program::create([
            'title'  => 'Власть и Грация 90',
            'type'   => ProgramType::Man->value,
            'period' => 90,
            'price'  => 16500,
        ]);

        Program::create([
            'title'  => 'Тайное Желание',
            'type'   => ProgramType::Man->value,
            'period' => 90,
            'price'  => 13200,
        ]);

        Program::create([
            'title'  => 'Тысяча Поцелуев 60',
            'type'   => ProgramType::Man->value,
            'period' => 60,
            'price'  => 7500,
        ]);

        Program::create([
            'title'  => 'Тысяча Поцелуев 90',
            'type'  => ProgramType::Man->value,
            'period' => 90,
            'price'  => 9500,
        ]);

        Program::create([
            'title'  => 'Касание Ангел',
            'type'   => ProgramType::Man->value,
            'period' => 90,
            'price'  => 10000,
        ]);

        Program::create([
            'title'  => 'Pink Show',
            'type'   => ProgramType::Man->value,
            'period' => 90,
            'price'  => 19500,
        ]);

        Program::create([
            'title'  => 'Камасутра 60',
            'type'   => ProgramType::Man->value,
            'period' => 60,
            'price'  => 11500,
        ]);

        Program::create([
            'title'  => 'Камасутра 90',
            'type'   => ProgramType::Man->value,
            'period' => 90,
            'price'  => 16500,
        ]);

        Program::create([
            'title'  => 'Райское Наслаждение',
            'type'   => ProgramType::Woman->value,
            'period' => 60,
            'price'  => 7500,
        ]);

        Program::create([
            'title'  => 'Эротическая Сказка',
            'type'   => ProgramType::Woman->value,
            'period' => 90,
            'price'  => 7900,
        ]);

        Program::create([
            'title'  => 'Соблазн',
            'type'   => ProgramType::Pair->value,
            'period' => 90,
            'price'  => 12700,
        ]);

        Program::create([
            'title'  => 'Интрига',
            'type'   => ProgramType::Pair->value,
            'period' => 90,
            'price'  => 16500,
        ]);

        Program::create([
            'title'  => 'Сближение',
            'type'   => ProgramType::Pair->value,
            'period' => 90,
            'price'  => 9500,
        ]);

        Program::create([
            'title'  => 'Тайная Фантазия',
            'type'   => ProgramType::Pair->value,
            'period' => 60,
            'price'  => 14500,
        ]);

        Program::create([
            'title'  => 'Беседа с Администратором 30',
            'type'   => ProgramType::All->value,
            'period' => 30,
            'price'  => 1500,
        ]);

        Program::create([
            'title'  => 'Беседа с Администратором 60',
            'type'   => ProgramType::All->value,
            'period' => 60,
            'price'  => 3000,
        ]);

        Program::create([
            'title'  => 'Аренда комнаты',
            'type'   => ProgramType::All->value,
            'period' => 60,
            'price'  => 3000,
        ]);

        Program::create([
            'title'  => 'Джакузи с администратором',
            'type'   => ProgramType::All->value,
            'period' => 60,
            'price'  => 7000,
        ]);

        Program::create([
            'title'  => 'Пикантные игры',
            'type'   => ProgramType::All->value,
            'period' => 60,
            'price'  => 5000,
        ]);
    }
}
