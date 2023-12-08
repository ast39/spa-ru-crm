@php

@endphp

@extends('layouts.app')

@section('title', __('Отчеты'))

@section('content')

    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Отчеты') }}</div>

        <div class="card-body bg-light">

            <!-- Фильтр -->
            <div class="mmot-margin20">
                @include('components/filters/reports')
            </div>

            <table class="table table-bordered">
                <thead class="table-secondary">
                <tr>
                    <th class="text-start">{{ __('Смена') }}</th>
                    <th class="text-end">{{ __('Доходы') }}</th>
                    <th class="text-end">{{ __('Расходы') }}</th>
                    <th class="text-end">{{ __('Баланс') }}</th>
                </tr>
                </thead>

                <tbody>
                @php
                    $profits = $wd = $balance = 0;
                @endphp

                @forelse($reports as $report)
                    <tr>
                        <td class="text-start"><a class="text-primary" href="{{ route('report.show', $report->report_id) }}">{{ $report->shift->title }} - {{ $report->shift->openedAdmin->name }}</a></td>
                        <td class="text-end">{{ number_format($report->cash_profit + $report->card_profit + $report->phone_profit, 0, '.', ' ') }} р.</td>
                        <td class="text-end">{{ number_format(0 - $report->admin_profit - $report->masters_profit - $report->expenses - $report->sale_sum, 0, '.', ' ') }} р.</td>
                        <td class="text-end">{{ number_format($report->cash_profit + $report->card_profit + $report->phone_profit - $report->admin_profit - $report->masters_profit - $report->expenses - $report->sale_sum, 0, '.', ' ') }} р.</td>
                    </tr>

                    @php
                        $profits += ($report->cash_profit + $report->card_profit + $report->phone_profit);
                        $wd -= ($report->admin_profit + $report->masters_profit + $report->expenses + $report->sale_sum);
                        $balance += ($report->cash_profit + $report->card_profit + $report->phone_profit - $report->admin_profit - $report->masters_profit - $report->expenses - $report->sale_sum)
                    @endphp
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ ('Отчетностей нет') }}</div>
                        </td>
                    </tr>
                @endforelse

                <tr><td colspan="4"></td></tr>

                <tr>
                    <td class="text-end">{{ __('За месяц') }}</td>
                    <td class="text-end">{{ number_format($profits, 0, '.', ' ') }} {{ __('р.') }}</td>
                    <td class="text-end">{{ number_format($wd, 0, '.', ' ') }} {{ __('р.') }}</td>
                    <td class="text-end">{{ number_format($balance, 0, '.', ' ') }} {{ __('р.') }}</td>
                </tr>

                <div>
                    {{ $reports->links() }}
                </div>
                </tbody>
            </table>

        </div>
        <div class="card-footer bg-light border-0"></div>
    </div>
@endsection
