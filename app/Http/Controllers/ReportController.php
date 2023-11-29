<?php

namespace App\Http\Controllers;

use App\Http\Traits\Dictionarable;
use App\Models\Report;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;


class ReportController extends Controller {

    use Dictionarable;


    public function show(int $id): View|RedirectResponse
    {
        if ($id !== (Report::query()->max('report_id') ?: null) && !Gate::allows('root-user')) {
            return redirect()->route('shift.index');
        }

        $report = Report::query()->findOrFail($id);

        return view('report.show', [
            'report' => $report,
        ]);
    }

}
