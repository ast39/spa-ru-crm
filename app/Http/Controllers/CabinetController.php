<?php

namespace App\Http\Controllers;

use App\Http\Enums\RoleType;
use App\Http\Requests\Cabinet\CabinetFilterRequest;
use App\Http\Traits\Dictionarable;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;


class CabinetController extends Controller {

    use Dictionarable;


    public function __invoke(): RedirectResponse|View
    {
        if (!Gate::allows('owner')) {
            $id = Report::query()->max('report_id') ?: 0;

            return redirect()->route('report.show', $id);
        }

        $reports = Report::query()->orderByDesc('created_at')
            ->paginate(10);

        return view('cabinet.index', [
            'reports' => $reports
        ]);
    }

}
