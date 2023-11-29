<?php

namespace App\Http\Controllers\Shift;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seance\SeanceProgramStoreRequest;
use App\Http\Requests\Seance\SeanceProgramUpdateRequest;
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

            $seance_id = SeanceProgram::query()->create($data)->seance_id;

            if (!is_null($data['services'] ?? null)) {
                foreach ($data['services'] as $service_id => $service_order) {
                    if ($service_order['amount'] == 0) {
                        continue;
                    }

                    SeanceService::query()->create([
                        'shift_id' => $data['shift_id'],
                        'seance_id' => $seance_id,
                        'admin_id' => $data['admin_id'],
                        'master_id' => $data['master_id'],
                        'guest' => $data['guest'] ?? '',
                        'service_id' => $service_id,
                        'amount' => $service_order['amount'],
                        'sale' => $data['sale'],
                        'gift' => (int) !is_null($service_order['gift'] ?? null),
                        'pay_type' => $data['pay_type'],
                        'note' => '',
                    ]);
                }
            }

            if (!is_null($data['bar'] ?? null)) {
                foreach ($data['bar'] as $item_id => $item_order) {
                    if ($item_order['amount'] == 0) {
                        continue;
                    }

                    SeanceBar::query()->create([
                        'shift_id' => $data['shift_id'],
                        'seance_id' => $seance_id,
                        'admin_id' => $data['admin_id'],
                        'guest' => $data['guest'] ?? '',
                        'item_id' => $item_id,
                        'amount' => $item_order['amount'],
                        'sale' => $data['sale'],
                        'gift' => (int) !is_null($item_order['gift'] ?? null),
                        'pay_type' => $data['pay_type'],
                        'note' => '',
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('shift.program.show', $seance_id);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('SeanceController:store', ['message' => $e->getMessage()]);

            return redirect()->back();
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

            SeanceService::where('seance_id', $seance->seance_id)->delete();

            if (!is_null($data['services'] ?? null)) {
                foreach ($data['services'] as $service_id => $service_order) {
                    if ($service_order['amount'] == 0) {
                        continue;
                    }

                    SeanceService::query()->create([
                        'shift_id' => $seance->shift_id,
                        'seance_id' => $seance->seance_id,
                        'admin_id' => $seance->admin_id,
                        'master_id' => $data['master_id'],
                        'guest' => $data['guest'] ?? '',
                        'service_id' => $service_id,
                        'amount' => $service_order['amount'],
                        'sale' => $data['sale'],
                        'gift' => (int) !is_null($service_order['gift'] ?? null),
                        'pay_type' => $data['pay_type'],
                        'note' => '',
                    ]);
                }
            }

            SeanceBar::where('seance_id', $seance->seance_id)->delete();

            if (!is_null($data['bar'] ?? null)) {
                foreach ($data['bar'] as $item_id => $item_order) {
                    if ($item_order['amount'] == 0) {
                        continue;
                    }

                    SeanceBar::query()->create([
                        'shift_id' => $seance->shift_id,
                        'seance_id' => $seance->seance_id,
                        'admin_id' => $seance->admin_id,
                        'guest' => $data['guest'] ?? '',
                        'item_id' => $item_id,
                        'amount' => $item_order['amount'],
                        'sale' => $data['sale'],
                        'gift' => (int) !is_null($item_order['gift'] ?? null),
                        'pay_type' => $data['pay_type'],
                        'note' => '',
                    ]);
                }
            }

            $seance->update(
                collect($data)->forget(['services', 'bar'])->toArray(),
            );

            DB::commit();

            return redirect()->route('shift.program.show', $seance->seance_id);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('SeanceController:store', ['message' => $e->getMessage()]);

            return redirect()->back();
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
