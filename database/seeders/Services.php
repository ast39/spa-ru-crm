<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class Services extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Service::create([
            'title' => 'Дополнение к программам «Искушение»',
            'price' => 2500,
        ]);

        Service::create([
            'title' => 'Дополнение к программам «Peep Show»',
            'price' => 4500,
        ]);

        Service::create([
            'title' => 'Приватный танец',
            'price' => 1500,
        ]);

        Service::create([
            'title' => 'Джакузи',
            'price' => 500,
        ]);

        Service::create([
            'title' => 'Эротика в джакузи',
            'price' => 1500,
        ]);

        Service::create([
            'title' => 'Foot fetish',
            'price' => 2000,
        ]);


    }
}
