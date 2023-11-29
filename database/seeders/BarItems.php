<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bar;

class BarItems extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bar::query()->create([
            'title'   => 'Пиво',
            'portion' => '0.5л',
            'price'   => 250,
        ]);

        Bar::query()->create([
            'title'   => 'Вино',
            'portion' => '200мл',
            'price'   => 300,
        ]);

        Bar::query()->create([
            'title'   => 'Вино',
            'portion' => 'Бутылка',
            'price'   => 2000,
        ]);

        Bar::query()->create([
            'title'   => 'Шампанское сл.',
            'portion' => 'Бутылка',
            'price'   => 2000,
        ]);

        Bar::query()->create([
            'title'   => 'Шампанское сух.',
            'portion' => 'Бутылка',
            'price'   => 2000,
        ]);

        Bar::query()->create([
            'title'   => 'Шампанское п/с',
            'portion' => 'Бутылка',
            'price'   => 2500,
        ]);

        Bar::query()->create([
            'title'   => 'Виски',
            'portion' => '0.5л',
            'price'   => 4000,
        ]);

        Bar::query()->create([
            'title'   => 'Виски',
            'portion' => '0.7л',
            'price'   => 5000,
        ]);

        Bar::query()->create([
            'title'   => 'Виски',
            'portion' => '1л',
            'price'   => 5500,
        ]);

        Bar::query()->create([
            'title'   => 'Виски + Кола',
            'portion' => '50мл',
            'price'   => 400,
        ]);

        Bar::query()->create([
            'title'   => 'Коньяк стопка',
            'portion' => '50мл',
            'price'   => 400,
        ]);
    }
}
