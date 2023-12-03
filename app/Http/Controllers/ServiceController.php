<?php

namespace App\Http\Controllers;

use App\Http\Filters\ServiceFilter;
use App\Http\Requests\Service\ServiceFilterRequest;
use App\Http\Requests\Service\ServiceStoreRequest;
use App\Http\Requests\Service\ServiceUpdateRequest;
use App\Models\Service;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;


/**
 * Блок управления услугами
 */
class ServiceController extends Controller {

    /**
     * Ассортимент услуг
     *
     * @param ServiceFilterRequest $request
     * @return View
     * @throws BindingResolutionException
     */
    public function index(ServiceFilterRequest $request): View
    {
        $data = $request->validated();

        $filter = app()->make(ServiceFilter::class, [
            'queryParams' => array_filter($data)
        ]);

        $page_services = Service::filter($filter)
            ->orderBy('title')
            ->paginate(config('limits.service'));

        return view('service.index', [
            'services' => $page_services,
        ]);
    }

    /**
     * Информация по услуге
     *
     * @param $id
     * @return View
     */
    public function show($id): View
    {
        $service = Service::findOrFail($id);

        return view('service.show', [
            'service' => $service,
        ]);
    }

    /**
     * Форма создания новой услуги
     *
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        if (!Gate::allows('owner')) {
            return redirect()->route('shift.index');
        }

        return view('service.create');
    }

    /**
     * Сохранение новой услуги
     *
     * @param ServiceStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ServiceStoreRequest $request): RedirectResponse
    {
        if (!Gate::allows('owner')) {
            return redirect()->route('shift.index');
        }

        $data = $request->validated();

        Service::query()->create($data);

        return redirect()->route('dict.service.index');
    }

    /**
     * Форма редактирования услуги
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $service = Service::query()->findOrFail($id);

        return view('service.edit', [
            'service' => $service,
        ]);
    }

    /**
     * Обновление данных услуги
     *
     * @param ServiceUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(ServiceUpdateRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();

        $service = Service::query()->findOrFail($id);

        $service->update($data);

        return redirect()->route('dict.service.index');
    }

    /**
     * Удаление услуги
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        if (!Gate::allows('owner')) {
            return redirect()->route('shift.index');
        }

        $service = Service::query()->findOrFail($id);

        if (is_null($service)) {
            return back()->withErrors(['action' => 'Удаляемый доп. услуга не найдена']);
        }

        $service->delete();

        return redirect()->route('dict.service.index');
    }
}
