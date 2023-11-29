<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BarController;
use App\Http\Controllers\CabinetController;
use App\Http\Controllers\MasterController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\Shift\ProgramController as ShiftProgram;
use App\Http\Controllers\Shift\ServiceController as ShiftService;
use App\Http\Controllers\Shift\BarController as ShiftBar;
use App\Http\Controllers\Shift\ShiftController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/cabinet');
});

Route::group(['middleware' => ['auth']], function() {

    # Кабинет
    Route::get('cabinet', [CabinetController::class, 'index'])->middleware('auth')->name('cabinet.index');
    Route::get('cabinet/owner', [CabinetController::class, 'owner'])->middleware('auth')->name('cabinet.owner');
    Route::get('cabinet/admin/{id?}', [CabinetController::class, 'admin'])->middleware('auth')->name('cabinet.admin');
    Route::get('cabinet/master/{id?}', [CabinetController::class, 'master'])->middleware('auth')->name('cabinet.master');

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

        # Программы смены
        Route::group(['prefix' => 'program'], function () {
            Route::get('create', [ShiftProgram::class, 'create'])->name('shift.program.create');
            Route::post('', [ShiftProgram::class, 'store'])->name('shift.program.store');
            Route::get('{id}', [ShiftProgram::class, 'show'])->name('shift.program.show');
            Route::get('edit/{id}', [ShiftProgram::class, 'edit'])->name('shift.program.edit');
            Route::put('{id}', [ShiftProgram::class, 'update'])->name('shift.program.update');
            Route::delete('{id}', [ShiftProgram::class, 'destroy'])->name('shift.program.destroy');
        });

        # Доп. услуги смены
        Route::group(['prefix' => 'service'], function () {
            Route::get('create', [ShiftService::class, 'create'])->name('shift.service.create');
            Route::post('', [ShiftService::class, 'store'])->name('shift.service.store');
            Route::get('{id}', [ShiftService::class, 'show'])->name('shift.service.show');
            Route::get('edit/{id}', [ShiftService::class, 'edit'])->name('shift.service.edit');
            Route::put('{id}', [ShiftService::class, 'update'])->name('shift.service.update');
            Route::delete('{id}', [ShiftService::class, 'destroy'])->name('shift.service.destroy');
        });

        # Бар смены
        Route::group(['prefix' => 'bar'], function () {
            Route::get('create', [ShiftBar::class, 'create'])->name('shift.bar.create');
            Route::post('', [ShiftBar::class, 'store'])->name('shift.bar.store');
            Route::get('{id}', [ShiftBar::class, 'show'])->name('shift.bar.show');
            Route::get('edit/{id}', [ShiftBar::class, 'edit'])->name('shift.bar.edit');
            Route::put('{id}', [ShiftBar::class, 'update'])->name('shift.bar.update');
            Route::delete('{id}', [ShiftBar::class, 'destroy'])->name('shift.bar.destroy');
        });
    });

    # Отчеты
    Route::group(['prefix' => 'report'], function () {

        Route::post('', [ReportController::class, 'store'])->name('report.store');
        Route::get('{id}', [ReportController::class, 'show'])->name('report.show');
    });

});

Route::get('clear', [CabinetController::class, 'clear']);

Auth::routes(['verify' => true]);
