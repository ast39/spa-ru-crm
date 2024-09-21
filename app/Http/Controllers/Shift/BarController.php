<?php

namespace App\Http\Controllers\Shift;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seance\SeanceBarStoreRequest;
use App\Http\Requests\Seance\SeanceBarUpdateRequest;
use App\Http\Services\PushTgService;
use App\Http\Services\ShiftHelper;
use App\Http\Traits\Dictionarable;
use App\Models\SeanceBar;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;


class BarController extends Controller {

    use Dictionarable;


    /**
     * @param $id
     * @return View
     */
    public function show($id): View
    {
        $seance = SeanceBar::findOrFail($id);

        return view('seance.bar.show', [
            'seance' => $seance,
        ]);
    }

    /**
     * Форма продажи товаров
     *
     * @return View
     */
    public function create(): View
    {
        return view('seance.bar.create', [
            'admins'   => $this->admins(),
            'masters'  => $this->masters(),
            'bar' => $this->bar(),
        ]);
    }

    /**
     * Продажа позиций товаров
     *
     * @param SeanceBarStoreRequest $request
     * @return RedirectResponse
     */
    public function store(SeanceBarStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['admin_id']  = Auth::id();
        $data['shift_id']  = ShiftHelper::currentShiftId();
        $data['seance_id'] = null;

        try {
            DB::beginTransaction();

            $bar = SeanceBar::create($data);
            $bar_id = $bar->record_id;
            PushTgService::bar(SeanceBar::find($bar_id));

            DB::commit();

            return redirect()->route('shift.index');

        } catch (\Exception $e) {

            DB::rollBack();
            Log::error(__CLASS__, ['message' => $e->getMessage()]);

            return redirect()->back()->withErrors(['err' => $e->getMessage()]);
        }
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $bar = SeanceBar::query()->findOrFail($id);

        return view('seance.bar.edit', [
            'seance'   => $bar,
            'admins'   => $this->admins(),
            'masters'  => $this->masters(),
            'programs' => $this->programs(),
            'services' => $this->services(),
            'bar' => $this->bar(),
        ]);
    }

    /**
     * @param SeanceBarUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(SeanceBarUpdateRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();

        $seance_bar = SeanceBar::query()->findOrFail($id);
        $seance_bar->update($data);

        return redirect()->route('shift.index');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $seance_bar = SeanceBar::query()->findOrFail($id);

        $seance_bar->delete();

        return redirect()->route('shift.index');
    }
}
