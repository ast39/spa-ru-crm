<?php

namespace App\Http\Controllers\Shift;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Seance;
use App\Http\Controllers\SeanceItem;
use App\Http\Controllers\SeanceUpdateRequest;
use App\Http\Requests\Seance\SeanceBarStoreRequest;
use App\Http\Requests\Seance\SeanceBarUpdateRequest;
use App\Http\Requests\Seance\SeanceProgramStoreRequest;
use App\Http\Requests\Seance\SeanceServiceStoreRequest;
use App\Http\Services\ShiftHelper;
use App\Http\Traits\Dictionarable;
use App\Models\SeanceBar;
use App\Models\SeanceProgram;
use App\Models\SeanceService;
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
     * Форма породажи бара
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
     * Продажа позиций бара
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

            if (!is_null($data['bar'] ?? null)) {
                foreach ($data['bar'] as $item_id => $item_order) {
                    if ($item_order['amount'] == 0) {
                        continue;
                    }

                    SeanceBar::query()->create([
                        'shift_id' => $data['shift_id'],
                        'seance_id' => $data['seance_id'],
                        'admin_id' => $data['admin_id'],
                        'guest' => $data['guest'] ?? '',
                        'item_id' => $item_id,
                        'amount' => $item_order['amount'],
                        'sale' => $data['sale'],
                        'gift' => (int) !is_null($item_order['gift'] ?? null),
                        'pay_type' => $data['pay_type'],
                        'note' => $data['note'] ?? '',
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('shift.index');

        } catch (\Exception $e) {

            DB::rollBack();
            Log::error(__CLASS__, ['message' => $e->getMessage()]);

            return redirect()->back();
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
        $data['gift'] = (int) !is_null($data['gift'] ?? null);

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
