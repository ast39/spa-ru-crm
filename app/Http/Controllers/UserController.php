<?php

namespace App\Http\Controllers;

use App\Http\Filters\UserFilter;
use App\Http\Requests\User\UserFilterRequest;
use App\Http\Requests\User\UserStoreRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Models\User;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;


/**
 * Блок управления пользователями
 */
class UserController extends Controller {

    public function __construct()
    {
        $this->middleware('access.admin');
    }

    /**
     * Список пользователей
     *
     * @param UserFilterRequest $request
     * @return RedirectResponse|View
     * @throws BindingResolutionException
     */
    public function index(UserFilterRequest $request): RedirectResponse|View
    {
        $data = $request->validated();

        $filter = app()->make(UserFilter::class, [
            'queryParams' => array_filter($data)
        ]);

        $page_users = User::filter($filter)
            ->where('id', '!=', 1)
            ->orderBy('name')
            ->paginate(config('limits.user'));

        return view('user.index', [
            'users' => $page_users,
        ]);
    }

    /**
     * Информация по пользователю
     *
     * @param int $id
     * @return RedirectResponse|View
     */
    public function show(int $id): RedirectResponse|View
    {
        $user = User::query()->findOrFail($id);

        return view('user.show', [
            'user' => $user,
        ]);
    }

    /**
     * Форма создания нового пользователя
     *
     * @return RedirectResponse|View
     */
    public function create(): RedirectResponse|View
    {
        return view('user.create');
    }

    /**
     * Сохранение нового пользователя
     *
     * @param UserStoreRequest $request
     * @return RedirectResponse
     */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['password'] = Hash::make($data['password']);

        $roles = $data['role'] == 5
            ? [2, 3]
            : $data['role'];

        try {
            DB::beginTransaction();
            $user = User::query()->create($data);
            $user->roles()->attach($roles);
            DB::commit();

            return redirect()->route('dict.user.index');
        } catch (\Exception $e) {

            DB::rollBack();
            Log::error(__CLASS__, ['message' => $e->getMessage()]);

            return redirect()->route('dict.user.index');
        }
    }

    /**
     * Форма редактирования пользователя
     *
     * @param int $id
     * @return RedirectResponse|View
     */
    public function edit(int $id): RedirectResponse|View
    {
        $user = User::query()->findOrFail($id);

        return view('user.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Обновление данных пользователя
     *
     * @param UserUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(UserUpdateRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();

        $user = User::query()->find($id);

        if (is_null($user)) {
            return back()->withErrors(['action' => 'Пользователь не найден']);
        }

        $roles = $data['role'] == 5
            ? [2, 3]
            : $data['role'];

        try {
            DB::beginTransaction();
            $user->update($data);
            $user->roles()->sync($roles);
            DB::commit();

            return redirect()->route('dict.user.index');
        } catch (\Exception $e) {

            DB::rollBack();
            Log::error(__CLASS__, ['message' => $e->getMessage()]);

            return redirect()->route('dict.user.index');
        }
    }

    /**
     * Удаление пользователя
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $user = User::query()->findOrFail($id);

        $user->delete();

        return redirect()->route('dict.user.index');
    }
}
