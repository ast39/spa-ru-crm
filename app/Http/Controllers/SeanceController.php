<?php

namespace App\Http\Controllers;

use App\Http\Requests\Seance\SeanceBarStoreRequest;
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

class SeanceController extends Controller {

    use Dictionarable;


    /**
     * Форма продажи программ
     *
     * @return View
     */
    public function createProgram(): View
    {
        return view('seance.create_program', [
            'admins'   => $this->admins(),
            'masters'  => $this->masters(),
            'programs' => $this->programs(),
            'services' => $this->services(),
            'bar'      => $this->bar(),
        ]);
    }

    /**
     * Форма продажи услуг
     *
     * @return View
     */
    public function createService(): View
    {
        return view('seance.create_service', [
            'admins'   => $this->admins(),
            'masters'  => $this->masters(),
            'services' => $this->services(),
        ]);
    }

    /**
     * Форма породажи бара
     *
     * @return View
     */
    public function createBar(): View
    {
        return view('seance.create_bar', [
            'admins'   => $this->admins(),
            'masters'  => $this->masters(),
            'bar' => $this->bar(),
        ]);
    }

    /**
     * Продажа сеанса (программы)
     *
     * @param SeanceProgramStoreRequest $request
     * @return RedirectResponse
     */
    public function programStore(SeanceProgramStoreRequest $request): RedirectResponse
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
                        'note' => $data['note'] ?? '',
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
                        'note' => $data['note'] ?? '',
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('seance.show', $seance_id);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('SeanceController:store', ['message' => $e->getMessage()]);

            return redirect()->back();
        }
    }

    /**
     * Продажа доп. услуг
     *
     * @param SeanceServiceStoreRequest $request
     * @return RedirectResponse
     */
    public function serviceStore(SeanceServiceStoreRequest $request): RedirectResponse
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
     * Продажа позиций бара
     *
     * @param SeanceBarStoreRequest $request
     * @return RedirectResponse
     */
    public function barStore(SeanceBarStoreRequest $request): RedirectResponse
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
     * @param $id
     * @return View
     */
    public function showProgram($id): View
    {
        $seance = SeanceProgram::findOrFail($id);

        return view('seance.program.show', [
            'seance' => $seance,
        ]);
    }

    /**
     * @param $id
     * @return View
     */
    public function showService($id): View
    {
        $seance = SeanceService::findOrFail($id);

        return view('seance.service.show', [
            'seance' => $seance,
        ]);
    }

    /**
     * @param $id
     * @return View
     */
    public function showBar($id): View
    {
        $seance = SeanceBar::findOrFail($id);

        return view('seance.bar.show', [
            'seance' => $seance,
        ]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $seance = Seance::findOrFail($id);

        return view('seance.edit', [
            'seance'   => $seance,
            'admins'   => $this->admins(),
            'masters'  => $this->masters(),
            'programs' => $this->programs(),
            'services' => $this->services(),
            'items'    => $this->items(),
        ]);
    }

    /**
     * @param SeanceUpdateRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(SeanceUpdateRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();
        $data['admin_id'] = Auth::id();

        $seance = Seance::find($id);

        if (is_null($seance)) {
            return back()->withErrors(['action' => 'Обновляемый сеанс не найден']);
        }

        try {
            DB::beginTransaction();

            $seance->update($data);

            SeanceService::query()->where('seance_id', $seance->seance_id)->delete();

            foreach ($data['services'] as $service_id => $service_order) {
                SeanceService::query()->create([
                    'seance_id'  => $id,
                    'service_id' => $service_id,
                    'amount'     => 1,
                    'gift'       => (int) !is_null($service_order['gift'] ?? null),
                ]);
            }

            SeanceItem::query()->where('seance_id', $seance->seance_id)->delete();

            foreach ($data['items'] as $item_id => $item_order) {
                if ($item_order['amount'] == 0) {
                    continue;
                }

                SeanceItem::query()->create([
                    'seance_id' => $id,
                    'item_id'   => $item_id,
                    'amount'    => $item_order['amount'],
                ]);
            }

            DB::commit();

            return redirect()->route('seance.show', $id);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('SeanceController:update', ['message' => $e->getMessage()]);

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

        try {
            DB::beginTransaction();
            if (!is_null($seance->services())) {
                foreach ($seance->services() as $service) {
                    $service->delete();
                }
            }

            if (!is_null($seance->bar())) {
                foreach ($seance->bar() as $item) {
                    $item->delete();
                }
            }

            $seance->delete();
            DB::commit();

            return redirect()->route('seance.index');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('SeanceController:update', ['message' => $e->getMessage()]);

            return redirect()->back();
        }
    }
}
