<?php

namespace App\Http\Controllers;

use App\Http\Filters\BarFilter;
use App\Http\Requests\Bar\ItemFilterRequest;
use App\Http\Requests\Bar\ItemStoreRequest;
use App\Http\Requests\Bar\ItemUpdateRequest;
use App\Models\Bar;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;


/**
 * Блок управления баром
 */
class BarController extends Controller {

    /**
     * Ассортимент бара
     *
     * @param ItemFilterRequest $request
     * @return View
     * @throws BindingResolutionException
     */
    public function index(ItemFilterRequest $request): View
    {
        $data = $request->validated();

        $filter = app()->make(BarFilter::class, [
            'queryParams' => array_filter($data)
        ]);

        $page_bar = Bar::filter($filter)
            ->orderBy('title')
            ->paginate(config('limits.bar'));

        return view('bar.index', [
            'bar' => $page_bar,
        ]);
    }

    /**
     * Информация по позиции бара
     *
     * @param $id
     * @return View
     */
    public function show($id): View
    {
        $bar = Bar::findOrFail($id);

        return view('bar.show', [
            'bar' => $bar,
        ]);
    }

    /**
     * Форма создания новой позиции бара
     *
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        if (!Gate::allows('owner')) {
            return redirect()->route('shift.index');
        }

        return view('bar.create');
    }

    /**
     * Сохранение новой позиции бара
     *
     * @param ItemStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ItemStoreRequest $request): RedirectResponse
    {
        if (!Gate::allows('owner')) {
            return redirect()->route('shift.index');
        }

        $data = $request->validated();

        Bar::query()->create($data);

        return redirect()->route('dict.bar.index');
    }

    /**
     * Форма редактирования позиции бара
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $bar = Bar::query()->findOrFail($id);

        return view('bar.edit', [
            'bar' => $bar,
        ]);
    }

    /**
     * Обновление данных позиции бара
     *
     * @param ItemUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(ItemUpdateRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();

        $bar = Bar::query()->find($id);

        $bar->update($data);

        return redirect()->route('dict.bar.index');
    }

    /**
     * Удаление позиции бара
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        if (!Gate::allows('owner')) {
            return redirect()->route('shift.index');
        }

        $bar = Bar::query()->findOrFail($id);

        $bar->delete();

        return redirect()->route('dict.bar.index');
    }
}
