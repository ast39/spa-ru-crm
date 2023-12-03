<?php

namespace App\Http\Controllers;

use App\Http\Enums\RoleType;
use App\Http\Filters\AdminFilter;
use App\Http\Requests\Admin\AdminFilterRequest;
use App\Http\Requests\Admin\AdminUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;


/**
 * Блок управления администраторами
 */
class AdminController extends Controller {

    public function __construct()
    {
        $this->middleware('access.owner');
    }

    /**
     * Список администраторов
     *
     * @param AdminFilterRequest $request
     * @return RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function index(AdminFilterRequest $request): RedirectResponse|View
    {
        $data = $request->validated();

        $filter = app()->make(AdminFilter::class, [
            'queryParams' => array_filter($data)
        ]);

        $page_admins = User::filter($filter)
            ->onlyAdmins()
            ->orderBy('name')
            ->paginate(config('limits.admin'));

        return view('admin.index', [
            'admins' => $page_admins,
        ]);
    }

    /**
     * Инфлрмация по администратору
     *
     * @param $id
     * @return RedirectResponse|View
     */
    public function show($id): RedirectResponse|View
    {
        $admin = User::findOrFail($id);

        if (!$admin->checkRole(RoleType::Administrator->value)) {
            return redirect()->route('dict.admin.index');
        }

        return view('admin.show', [
            'admin' => $admin,
        ]);
    }

    /**
     * Форма редактирования заработка администратора
     *
     * @param int $id
     * @return RedirectResponse|View
     */
    public function edit(int $id): RedirectResponse|View
    {
        $admin = User::findOrFail($id);

        if (!$admin->checkRole(RoleType::Administrator->value)) {
            return redirect()->route('dict.admin.index');
        }

        return view('admin.edit', [
            'admin' => $admin,
        ]);
    }

    /**
     * Обновлениу заработка администратора
     *
     * @param AdminUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(AdminUpdateRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();

        $admin = User::findOrFail($id);

        if (!$admin->checkRole(RoleType::Administrator->value)) {
            return redirect()->route('dict.admin.index');
        }

        try {
            DB::beginTransaction();
            $admin->roles()->detach(RoleType::Administrator->value);
            $admin->roles()->attach(RoleType::Administrator->value, $data);
            DB::commit();

            return redirect()->route('dict.admin.index');
        } catch (\Exception $e) {

            DB::rollBack();
            Log::error(__CLASS__, ['message' => $e->getMessage()]);

            return redirect()->route('dict.admin.index');
        }
    }

    /**
     * Удаление с роли администратора
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $admin = User::findOrFail($id);

        if (!$admin->checkRole(RoleType::Administrator->value)) {
            return redirect()->route('dict.admin.index');
        }

        $admin->roles()->detach(RoleType::Administrator->value);

        return redirect()->route('dict.admin.index');
    }
}
