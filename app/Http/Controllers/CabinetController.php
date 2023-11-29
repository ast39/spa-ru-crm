<?php

namespace App\Http\Controllers;

use App\Http\Enums\RoleType;
use App\Http\Enums\SoftStatus;
use App\Http\Traits\Dictionarable;
use App\Models\Report;
use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;


class CabinetController extends Controller {

    use Dictionarable;


    /**
     * Обработчик кабинета пользователя
     *
     * @return RedirectResponse
     */
    public function index(): RedirectResponse
    {
        if (Gate::allows('owner')) {
            return redirect()->route('cabinet.owner');
        } else if (Gate::allows('admin')) {
            return redirect()->route('cabinet.admin');
        } else if (Gate::allows('master')) {
            return redirect()->route('cabinet.master');
        } else {
            return redirect()->route('shift.index');
        }
    }

    public function owner(): RedirectResponse|View
    {
        if (!Gate::allows('owner')) {
            $id = Report::query()->max('report_id') ?: 0;

            return redirect()->route('report.show', $id);
        }

        $reports = Report::query()->orderByDesc('created_at')
            ->paginate(30);

        return view('cabinet.owner.index', [
            'reports' => $reports
        ]);
    }

    /**
     * Кабинет администратора
     *
     * @param int|null $id
     * @return RedirectResponse|View
     */
    public function admin(int $id = null): RedirectResponse|View
    {
        if (!Gate::allows('admin') && !Gate::allows('owner')) {
            $id = Report::query()->max('report_id') ?: 0;

            return redirect()->route('report.show', $id);
        }

        if (!Gate::allows('owner') || is_null($id)) {
            $id = Auth::id();
        }

        $user = User::query()->findOrFail($id);

        $month = Carbon::now(+2)->startOfDay()->subDays(30)->format('Y-m-d');
        $shifts = Shift::query()
            ->where('status', SoftStatus::On->value)
            ->where('title', '>=', $month)
            ->get();

        return view('cabinet.admin.show', [
            'user' => $user,
            'shifts' => $shifts,
        ]);
    }

    /**
     * Кабинет мастера
     *
     * @param int|null $id
     * @return RedirectResponse|View
     */
    public function master(int $id = null): RedirectResponse|View
    {
        if (!Gate::allows('master') && !Gate::allows('owner')) {
            $id = Report::query()->max('report_id') ?: 0;

            return redirect()->route('report.show', $id);
        }

        if (!Gate::allows('owner') || is_null($id)) {
            $id = Auth::id();
        }

        $user = User::query()->findOrFail($id);

        $month = Carbon::now(+2)->startOfDay()->subDays(30)->format('Y-m-d');
        $shifts = Shift::query()
            ->where('status', SoftStatus::On->value)
            ->where('title', '>=', $month)
            ->get();

        return view('cabinet.master.show', [
            'user' => $user,
            'shifts' => $shifts,
        ]);
    }

    /**
     * Список администраторов
     *
     * @return View
     */
    public function admins(): View
    {
        $admins = User::query()->whereHas('roles', function($query) {
            $query->where('role_id', RoleType::Administrator->value);
        })
            ->get();

        return view('cabinet.admin.index', [
            'admins' => $admins,
        ]);
    }

    /**
     * Список мастеров
     *
     * @return View
     */
    public function masters(): View
    {
        $masters = User::query()
            ->whereHas('roles', function($query) {
                $query->where('role_id', RoleType::Master->value);
            })
            ->whereDoesntHave('roles', function($query) {
                $query->where('role_id', RoleType::Administrator->value);
            })
            ->get();

        return view('cabinet.master.index', [
            'masters' => $masters,
        ]);
    }

}
