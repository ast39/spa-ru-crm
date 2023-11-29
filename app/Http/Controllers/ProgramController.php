<?php

namespace App\Http\Controllers;

use App\Http\Filters\ProgramFilter;
use App\Http\Requests\Program\ProgramFilterRequest;
use App\Http\Requests\Program\ProgramStoreRequest;
use App\Http\Requests\Program\ProgramUpdateRequest;
use App\Models\Program;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;


/**
 * Блок управления программами
 */
class ProgramController extends Controller {

    /**
     * Ассортимент программ
     *
     * @param ProgramFilterRequest $request
     * @return View
     * @throws BindingResolutionException
     */
    public function index(ProgramFilterRequest $request): View
    {
        $data = $request->validated();

        $filter = app()->make(ProgramFilter::class, [
            'queryParams' => array_filter($data)
        ]);

        $page_programs = Program::filter($filter)
            ->orderBy('title')
            ->paginate(config('limits.program'));

        return view('program.index', [
            'programs' => $page_programs,
        ]);
    }

    /**
     * Информация по программе
     *
     * @param $id
     * @return View
     */
    public function show($id): View
    {
        $program = Program::findOrFail($id);

        return view('program.show', [
            'program' => $program,
        ]);
    }

    /**
     * Форма создания новой программы
     *
     * @return View|RedirectResponse
     */
    public function create(): View|RedirectResponse
    {
        if (!Gate::allows('owner')) {
            return redirect()->route('shift.index');
        }

        return view('program.create');
    }

    /**
     * Сохранение новой программы
     *
     * @param ProgramStoreRequest $request
     * @return RedirectResponse
     */
    public function store(ProgramStoreRequest $request): RedirectResponse
    {
        if (!Gate::allows('owner')) {
            return redirect()->route('shift.index');
        }

        $data = $request->validated();

        Program::query()->create($data);

        return redirect()->route('dict.program.index');
    }

    /**
     * Форма редактирования проограммы
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $program = Program::query()->findOrFail($id);

        return view('program.edit', [
            'program' => $program,
        ]);
    }

    /**
     * Обновление данных программы
     *
     * @param ProgramUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(ProgramUpdateRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();

        $program = Program::query()->findOrFail($id);

        $program->update($data);

        return redirect()->route('dict.program.index');
    }

    /**
     * Удаление программы
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        if (!Gate::allows('owner')) {
            return redirect()->route('shift.index');
        }

        $program = Program::query()->findOrFail($id);

        $program->delete();

        return redirect()->route('dict.program.index');
    }
}
