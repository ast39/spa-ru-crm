@php
    use App\Http\Services\Helper;
@endphp

@extends('layouts.app')

@section('title', __('Рандеву - Сводка'))

@section('content')
    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Сводка') }}</div>

        <div class="card-body bg-light">

            <table class="table table-bordered">
                <thead class="table-secondary">
                <tr>
                    <th class="text-start">Смена</th>
                    <th class="text-end">Доходы</th>
                    <th class="text-end">Расходы</th>
                    <th class="text-end">Баланс</th>
                </tr>
                </thead>

                <tbody>
                @forelse($reports as $report)
                    <tr>
                        <td class="text-start"><a class="text-primary" href="{{ route('report.show', $report->report_id) }}">{{ $report->shift->title }}</a></td>
                        <td class="text-end">{{ number_format($report->cash_profit + $report->card_profit + $report->phone_profit, 0, '.', ' ') }} р.</td>
                        <td class="text-end">{{ number_format(0 - $report->admin_profit - $report->masters_profit - $report->expenses - $report->sale_sum, 0, '.', ' ') }} р.</td>
                        <td class="text-end">{{ number_format($report->cash_profit + $report->card_profit + $report->phone_profit - $report->admin_profit - $report->masters_profit - $report->expenses - $report->sale_sum, 0, '.', ' ') }} р.</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="2">
                            <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ ('Отчетностей нет') }}</div>
                        </td>
                    </tr>
                @endforelse

                <div>
                    {{ $reports->links() }}
                </div>
                </tbody>
            </table>

        </div>
        <div class="card-footer bg-light border-0"></div>
    </div>
@endsection
