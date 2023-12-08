<?php

namespace App\Http\Controllers;

use App\Http\Requests\Bar\ItemStoreRequest;
use App\Http\Traits\Dictionarable;
use App\Models\Bar;
use App\Models\Stock;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;


/**
 * Блок управления баром
 */
class StockController extends Controller {

    use Dictionarable;


    /**
     * Форма создания новой операции закупа / продажи
     *
     * @return View|RedirectResponse
     */
    public function index(): View|RedirectResponse
    {
        $stock = Stock::query()
            ->with(['admin', 'bar', 'shift'])
            ->orderByDesc('created_at')
            ->paginate(20);

        $bar = $this->bar();

        return view('stock.index', [
            'stock' => $stock,
            'bar' => $bar,
        ]);
    }

    /**
     * Форма создания новой операции закупа / продажи
     *
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        if (!Gate::allows('owner') && !Gate::allows('admin')) {
            return redirect()->route('shift.index');
        }

        $bar = $this->bar();

        return view('stock.create', [
            'bar' => $bar,
        ]);
    }

    /**
     * Сохранение новой операции закупа
     *
     * @param ItemStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ItemStoreRequest $request): RedirectResponse
    {
        if (!Gate::allows('owner') && !Gate::allows('admin')) {
            return redirect()->route('shift.index');
        }

        $data = $request->validated();

        Bar::query()->create($data);

        return redirect()->route('stock.index');
    }

    /**
     * Удаление операции закупа / продажи
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        if (!Gate::allows('owner') && !Gate::allows('admin')) {
            return redirect()->route('shift.index');
        }

        $data = $request->validated();

        Bar::query()->create($data);

        return redirect()->route('stock.index');
    }
}
