<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ShiftController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarController;
use App\Http\Controllers\CabinetController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SeanceController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/cabinet');
});

Route::group(['middleware' => ['auth']], function() {

    # Кабинет
    Route::get('cabinet', CabinetController::class)->middleware('auth')->name('cabinet.index');

    # Справочники
    Route::group(['prefix' => 'dict'], function () {

        # Пользователи
        Route::resource('user',UserController::class)
            ->names([
                'index' => 'dict.user.index',
                'show' => 'dict.user.show',
                'create' => 'dict.user.create',
                'store' => 'dict.user.store',
                'edit' => 'dict.user.edit',
                'update' => 'dict.user.update',
                'destroy' => 'dict.user.destroy',
            ]);

        # Администраторы
        Route::resource('admin',AdminController::class)
            ->except('create', 'store')
            ->names([
                'index' => 'dict.admin.index',
                'show' => 'dict.admin.show',
                'edit' => 'dict.admin.edit',
                'update' => 'dict.admin.update',
                'destroy' => 'dict.admin.destroy',
            ]);

        # Мастера
        Route::resource('master',MasterController::class)
            ->except('create', 'store')
            ->names([
                'index' => 'dict.master.index',
                'show' => 'dict.master.show',
                'edit' => 'dict.master.edit',
                'update' => 'dict.master.update',
                'destroy' => 'dict.master.destroy',
            ]);


        # Программы
        Route::resource('program',ProgramController::class)
            ->names([
                'index' => 'dict.program.index',
                'show' => 'dict.program.show',
                'create' => 'dict.program.create',
                'store' => 'dict.program.store',
                'edit' => 'dict.program.edit',
                'update' => 'dict.program.update',
                'destroy' => 'dict.program.destroy',
            ]);

        # Доп. услуги
        Route::resource('service',ServiceController::class)
            ->names([
                'index' => 'dict.service.index',
                'show' => 'dict.service.show',
                'create' => 'dict.service.create',
                'store' => 'dict.service.store',
                'edit' => 'dict.service.edit',
                'update' => 'dict.service.update',
                'destroy' => 'dict.service.destroy',
            ]);

        # Бар
        Route::resource('bar',BarController::class)
            ->names([
                'index' => 'dict.bar.index',
                'show' => 'dict.bar.show',
                'create' => 'dict.bar.create',
                'store' => 'dict.bar.store',
                'edit' => 'dict.bar.edit',
                'update' => 'dict.bar.update',
                'destroy' => 'dict.bar.destroy',
            ]);
    });

    # Смены
    Route::group(['prefix' => 'shift'], function () {

        Route::get('', [ShiftController::class, 'index'])->name('shift.index');
        Route::post('open', [ShiftController::class, 'open'])->name('shift.open');
        Route::post('close', [ShiftController::class, 'close'])->name('shift.close');
    });

    # Сеансы
    Route::group(['prefix' => 'seance'], function () {

        Route::get('program/{id}', [SeanceController::class, 'showProgram'])->name('seance.program.show');
        Route::get('program/create', [SeanceController::class, 'createProgram'])->name('seance.program.create');
        Route::get('program/edit', [SeanceController::class, 'editProgram'])->name('seance.program.edit');
        Route::post('program', [SeanceController::class, 'programStore'])->name('seance.program.store');
        Route::delete('program/{id}', [SeanceController::class, 'programDestroy'])->name('seance.program.destroy');

        Route::get('service/{id}', [SeanceController::class, 'showService'])->name('seance.service.show');
        Route::get('service/create', [SeanceController::class, 'createService'])->name('seance.service.create');
        Route::get('service/edit', [SeanceController::class, 'editService'])->name('seance.service.edit');
        Route::post('service', [SeanceController::class, 'serviceStore'])->name('seance.service.store');
        Route::delete('service', [SeanceController::class, 'serviceDestroy'])->name('seance.service.destroy');

        Route::get('bar/{id}', [SeanceController::class, 'showBar'])->name('seance.bar.show');
        Route::get('bar/create', [SeanceController::class, 'createBar'])->name('seance.bar.create');
        Route::get('bar/edit', [SeanceController::class, 'editBar'])->name('seance.bar.edit');
        Route::post('bar', [SeanceController::class, 'barStore'])->name('seance.bar.store');
        Route::delete('bar', [SeanceController::class, 'barDestroy'])->name('seance.bar.destroy');
    });

    # Отчеты
    Route::group(['prefix' => 'report'], function () {

        Route::post('', [ReportController::class, 'store'])->name('report.store');
        Route::get('{id}', [ReportController::class, 'show'])->name('report.show');
    });

});

Route::get('clear', [CabinetController::class, 'clear']);

Auth::routes(['verify' => true]);
