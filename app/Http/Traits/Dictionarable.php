<?php

namespace App\Http\Traits;

use App\Models\Admin;
use App\Models\Bar;
use App\Models\Service;
use App\Models\Master;
use App\Models\Program;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

trait Dictionarable {

    /**
     * Все администраторы
     *
     * @return Collection
     */
    private function admins(): Collection
    {
        return User::query()
            ->onlyAdmins()
            ->orderBy('name')
            ->get();
    }

    /**
     * Все мастера
     *
     * @return Collection
     */
    private function masters(): Collection
    {
        return User::query()
            ->onlyMasters()
            ->orderBy('name')
            ->get();
    }

    /**
     * Все программы
     *
     * @return Collection
     */
    private function programs(): Collection
    {
        return Program::query()
            ->orderBy('title')
            ->get();
    }

    /**
     * Все услуги
     *
     * @return Collection
     */
    private function services(): Collection
    {
        return Service::query()
            ->orderBy('title')
            ->get();
    }

    /**
     * Все товары
     *
     * @return Collection
     */
    private function bar(): Collection
    {
        return Bar::query()
            ->orderBy('title')
            ->get();
    }

}
