<?php

namespace App\Http\Controllers\Shift;

use App\Http\Controllers\Controller;
use App\Http\Requests\Seance\SeanceServiceStoreRequest;
use App\Http\Requests\Seance\SeanceServiceUpdateRequest;
use App\Http\Services\ShiftHelper;
use App\Http\Traits\Dictionarable;
use App\Models\SeanceProgram;
use App\Models\SeanceService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ServiceController extends Controller {

    use Dictionarable;


    /**
     * @param $id
     * @return View
     */
    public function show($id): View
    {
        $seance = SeanceService::findOrFail($id);

        return view('seance.service.show', [
            'seance' => $seance,
        ]);
    }

    /**
     * Форма продажи услуг
     *
     * @return View
     */
    public function create(): View
    {
        return view('seance.service.create', [
            'admins'   => $this->admins(),
            'masters'  => $this->masters(),
            'services' => $this->services(),
        ]);
    }

    /**
     * Продажа доп. услуг
     *
     * @param SeanceServiceStoreRequest $request
     * @return RedirectResponse
     */
    public function store(SeanceServiceStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['admin_id'] = Auth::id();
        $data['shift_id']  = ShiftHelper::currentShiftId();
        $data['seance_id'] = null;

        try {
            DB::beginTransaction();

            if (!is_null($data['services'] ?? null)) {
                foreach ($data['services'] as $service_id => $service_order) {
                    if ($service_order['amount'] == 0) {
                        continue;
                    }

                    SeanceService::query()->create([
                        'shift_id' => $data['shift_id'],
                        'seance_id' => $data['seance_id'],
                        'admin_id' => $data['admin_id'],
                        'master_id' => $data['master_id'],
                        'guest' => $data['guest'] ?? '',
                        'service_id' => $service_id,
                        'amount' => $service_order['amount'],
                        'sale' => $data['sale'],
                        'gift' => (int) !is_null($service_order['gift'] ?? null),
                        'pay_type' => $data['pay_type'],
                        'note' => $data['note'] ?? '',
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('shift.index');

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
        $service = SeanceService::findOrFail($id);

        return view('seance.service.edit', [
            'seance'   => $service,
            'admins'   => $this->admins(),
            'masters'  => $this->masters(),
            'programs' => $this->programs(),
            'services' => $this->services(),
            'items'    => $this->bar(),
        ]);
    }

    /**
     * @param SeanceServiceUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(SeanceServiceUpdateRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();
        $data['gift'] = (int) !is_null($data['gift'] ?? null);

        $seance_service = SeanceService::query()->findOrFail($id);
        $seance_service->update($data);

        return redirect()->route('shift.index');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $seance_service = SeanceService::query()->findOrFail($id);

        $seance_service->delete();

        return redirect()->route('shift.index');
    }
}
