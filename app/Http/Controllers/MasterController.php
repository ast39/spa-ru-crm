<?php

namespace App\Http\Controllers;

use App\Http\Enums\RoleType;
use App\Http\Filters\MasterFilter;
use App\Http\Requests\Master\MasterFilterRequest;
use App\Http\Requests\Master\MasterUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;


/**
 * Блок управления мастерами
 */
class MasterController extends Controller {

    public function __construct()
    {
        $this->middleware('access.admin');
    }

    /**
     * Список мастеров
     *
     * @param MasterFilterRequest $request
     * @return View
     * @throws BindingResolutionException
     */
    public function index(MasterFilterRequest $request): View
    {
        $data = $request->validated();

        $filter = app()->make(MasterFilter::class, [
            'queryParams' => array_filter($data)
        ]);

        $page_masters = User::filter($filter)
            ->onlyMasters()
            ->orderBy('name')
            ->paginate(config('limits.master'));

        return view('master.index', [
            'masters' => $page_masters,
        ]);
    }

    /**
     * Инфлрмация по мастеру
     *
     * @param $id
     * @return RedirectResponse|View
     */
    public function show($id): RedirectResponse|View
    {
        $master = User::findOrFail($id);

        if (!$master->checkRole(RoleType::Master->value)) {
            return redirect()->route('dict.master.index');
        }

        return view('master.show', [
            'master' => $master,
        ]);
    }

    /**
     * Форма редактирования заработка мастера
     *
     * @param int $id
     * @return RedirectResponse|View
     */
    public function edit(int $id): RedirectResponse|View
    {
        $master = User::findOrFail($id);

        if (!$master->checkRole(RoleType::Master->value)) {
            return redirect()->route('dict.master.index');
        }

        return view('master.edit', [
            'master' => $master,
        ]);
    }

    /**
     * Обновлениу заработка мастера
     *
     * @param MasterUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(MasterUpdateRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();

        $master = User::findOrFail($id);
        if (!$master->checkRole(RoleType::Master->value)) {
            return redirect()->route('dict.master.index');
        }

        try {
            DB::beginTransaction();
            $master->roles()->detach(RoleType::Master->value);
            $master->roles()->attach(RoleType::Master->value, $data);
            DB::commit();

            return redirect()->route('dict.master.index');
        } catch (\Exception $e) {

            DB::rollBack();
            Log::error(__CLASS__, ['message' => $e->getMessage()]);

            return redirect()->route('dict.master.index');
        }
    }

    /**
     * Удаление с роли мастера
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $master = User::findOrFail($id);

        if (!$master->checkRole(RoleType::Master->value)) {
            return redirect()->route('dict.master.index');
        }

        $master->roles()->detach(RoleType::Master->value);

        return redirect()->route('dict.master.index');
    }
}
