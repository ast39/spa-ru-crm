<?php

namespace App\Http\Controllers\Shift;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seance\SeanceProgramStoreRequest;
use App\Http\Requests\Seance\SeanceProgramUpdateRequest;
use App\Http\Services\PushTgService;
use App\Http\Services\ShiftHelper;
use App\Http\Traits\Dictionarable;
use App\Models\SeanceProgram;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;


class ProgramController extends Controller {

    use Dictionarable;


    /**
     * @param $id
     * @return View
     */
    public function show($id): View
    {
        $seance = SeanceProgram::findOrFail($id);

        return view('seance.program.show', [
            'seance' => $seance,
        ]);
    }

    /**
     * Форма продажи программ
     *
     * @return View
     */
    public function create(): View
    {
        return view('seance.program.create', [
            'admins'   => $this->admins(),
            'masters'  => $this->masters(),
            'programs' => $this->programs(),
            'services' => $this->services(),
            'bar'      => $this->bar(),
        ]);
    }

    /**
     * Продажа сеанса (программы)
     *
     * @param SeanceProgramStoreRequest $request
     * @return RedirectResponse
     */
    public function store(SeanceProgramStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['admin_id']  = Auth::id();
        $data['shift_id']  = ShiftHelper::currentShiftId();

        try {
            DB::beginTransaction();

            $seance = SeanceProgram::create($data);
            $seance_id = $seance->seance_id;
            PushTgService::program($seance);

            DB::commit();

            return redirect()->route('shift.program.show', $seance_id);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('SeanceController:store', ['message' => $e->getMessage()]);

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $seance = SeanceProgram::findOrFail($id);

        return view('seance.program.edit', [
            'seance'   => $seance,
            'admins'   => $this->admins(),
            'masters'  => $this->masters(),
            'programs' => $this->programs(),
            'services' => $this->services(),
            'bar' => $this->bar(),
        ]);
    }

    /**
     * @param SeanceProgramUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(SeanceProgramUpdateRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();
        $seance = SeanceProgram::query()->findOrFail($id);

        try {
            DB::beginTransaction();

            $seance->update($data);

            DB::commit();

            return redirect()->route('shift.program.show', $seance->seance_id);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('SeanceController:update', ['message' => $e->getMessage()]);

            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $seance = SeanceProgram::query()->findOrFail($id);

        $seance->delete();

        return redirect()->route('shift.index');
    }
}
