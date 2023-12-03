<?php

namespace App\Http\Controllers;

use App\Http\Enums\RoleType;
use App\Http\Enums\SoftStatus;
use App\Http\Filters\CabinetOwnerFilter;
use App\Http\Filters\ReportFilter;
use App\Http\Requests\Cabinet\CabinetOwnerFilterRequest;
use App\Http\Traits\Dictionarable;
use App\Models\Report;
use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\Container\BindingResolutionException;
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

    /**
     * Кабинет руководителя (зарплаты всех сотрудников)
     *
     * @param CabinetOwnerFilterRequest $request
     * @return RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function owner(CabinetOwnerFilterRequest $request): RedirectResponse|View
    {
        if (!Gate::allows('owner')) {
            return redirect()->route('cabinet.index');
        }

        $data = $request->validated();
        if (is_null($data['user'] ?? null)) {
            $data['user'] = User::query()->max('id');
        }

        $filter = app()->make(CabinetOwnerFilter::class, [
            'queryParams' => array_filter($data)
        ]);

        $shifts = Shift::with(['shiftPrograms', 'shiftServices'])
            ->filter($filter)
            ->where('status', SoftStatus::On->value)
            ->paginate(30);

        return view('cabinet.owner.index', [
            'shifts' => $shifts,
            'user' => User::query()->find($data['user']),
            'users' => User::query()
                ->orderBy('name')
                ->get(),
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
            return redirect()->route('cabinet.index');
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
        $id = Report::query()->max('report_id') ?: 0;

        if ((!Gate::allows('owner') && !Gate::allows('admin')) || is_null($id)) {
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

}
