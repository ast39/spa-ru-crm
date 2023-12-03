<?php

namespace App\Http\Controllers\Shift;

use App\Http\Controllers\Controller;
use App\Http\Enums\SoftStatus;
use App\Http\Requests\Seance\SeanceFilterRequest;
use App\Http\Requests\Shift\ShiftCloseStoreRequest;
use App\Http\Services\DailyReport;
use App\Http\Services\ShiftHelper;
use App\Http\Traits\Dictionarable;
use App\Models\Report;
use App\Models\SeanceBar;
use App\Models\SeanceProgram;
use App\Models\SeanceService;
use App\Models\Shift;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ShiftController extends Controller {

    use Dictionarable;


    /**
     * @param SeanceFilterRequest $request
     * @return View
     * @throws BindingResolutionException
     */
    public function index(SeanceFilterRequest $request): View
    {
        $seances = SeanceProgram::query()
            ->lastShift()
            ->orderByDesc('open_time')
            ->orderByDesc('created_at')
            ->get();

        $services = SeanceService::query()
            ->lastShift()
            ->orderByDesc('created_at')
            ->get();

        $bar = SeanceBar::query()
            ->lastShift()
            ->orderByDesc('created_at')
            ->get();

        return view('shift.index', [
            'seances' => $seances,
            'services' => $services,
            'bar' => $bar,
            'admins' => $this->admins(),
            'masters' => $this->masters(),
            'programs' => $this->programs(),
        ]);
    }

    /**
     * Открытие смены
     *
     * @return RedirectResponse
     */
    public function open(): RedirectResponse
    {
        Shift::query()->create([
            'title' => Carbon::now()->format('Y-m-d'),
            'opened_admin_id' => Auth::id(),
            'opened_time' => Carbon::now(),
            'status' => SoftStatus::Off->value,
        ]);

        return redirect()->route('shift.index');
    }

    /**
     * Закрытие смены
     *
     * @param ShiftCloseStoreRequest $request
     * @return RedirectResponse
     */
    public function close(ShiftCloseStoreRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $dl = new DailyReport(ShiftHelper::lastShift());

        $shift_id = ShiftHelper::currentShiftId();
        $shift = Shift::query()->find($shift_id);

        $data['shift_id'] = $shift_id;
        $data['clients'] = $dl->guests();
        $data['cash_profit'] = $dl->cash();
        $data['card_profit'] = $dl->card();
        $data['phone_profit'] = $dl->phone();
        $data['programs_profit'] = $dl->programs();
        $data['services_profit'] = $dl->services();
        $data['bar_profit'] = $dl->bar();
        $data['admin_profit'] = $dl->adminProfit();
        $data['masters_profit'] = $dl->mastersProfit();
        $data['sale_sum'] = $dl->saleSum();
        $data['owner_profit'] = $dl->ownerProfit();

        try {
            DB::beginTransaction();
            $shift->update([
                'closed_admin_id' => Auth::id(),
                'closed_time' => Carbon::now(+2),
                'status' => SoftStatus::On->value,
            ]);
            $report_id = Report::query()->create($data)->report_id;
            DB::commit();

            return redirect()->route('report.show', $report_id);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error(__CLASS__, ['message' => $e->getMessage()]);
            return redirect()->route('shift.index');
        }
    }
}
