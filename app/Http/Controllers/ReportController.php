<?php

namespace App\Http\Controllers;

use App\Http\Filters\ReportFilter;
use App\Http\Requests\Report\ReportFilterRequest;
use App\Http\Traits\Dictionarable;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;


class ReportController extends Controller {

    use Dictionarable;


    public function index(ReportFilterRequest $request)
    {
        if (!Gate::allows('owner')) {
            $id = Report::query()->max('report_id') ?: 0;

            return redirect()->route('report.show', $id);
        }

        $data = $request->validated();

        $filter = app()->make(ReportFilter::class, [
            'queryParams' => array_filter($data)
        ]);

        $reports = Report::filter($filter)
            ->orderByDesc('shift_id')
            ->paginate(30);

        return view('report.index', [
            'reports' => $reports
        ]);
    }

    public function show(?int $id = null): View|RedirectResponse
    {
        $id = is_null($id)
            ? Report::query()->max('report_id')
            : $id;

        if ($id !== (Report::query()->max('report_id') ?: null) && !Gate::allows('owner')) {
            return redirect()->route('shift.index');
        }

        $report = Report::query()->findOrFail($id);

        return view('report.show', [
            'report' => $report,
        ]);
    }

}
