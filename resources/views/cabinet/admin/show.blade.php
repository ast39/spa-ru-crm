@php
    use App\Http\Services\Helper;
@endphp

@extends('layouts.app')

@section('title', __('Кабинет администратора: ') . $user->name)

@section('content')
    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Кабинет администратора: ') . $user->name }}</div>

        <div class="card-body bg-light">

            <table class="table table-bordered">
                <thead class="table-secondary">
                <tr>
                    <th class="text-start">Смена</th>
                    <th class="text-end">Комиссия</th>
                    <th class="text-end">С программ</th>
                    <th class="text-end">Заработок</th>
                </tr>
                </thead>

                <tbody>
                @php
                    $commissions = $programs = $total = 0;
                @endphp

                @forelse($shifts as $shift)
                    @if ($shift->admin_profit['programs'] == 0 && $shift->admin_profit['services'] ==0 && $shift->admin_profit['bar'] == 0)
                        @continue
                    @endif

                    <tr>
                        <td class="text-start">{{ $shift->title }}</td>
                        <td class="text-end">{{ number_format($shift->admin_profit['programs'] + $shift->master_profit['services'] + $shift->master_profit['bar'], 0, '.', ' ') }} р.</td>
                        <td class="text-end">{{ number_format($shift->admin_profit['programs'] + $shift->master_profit['services'] + $shift->master_profit['bar'], 0, '.', ' ') }} р.</td>
                        <td class="text-end">{{ number_format($shift->admin_profit['programs'] + $shift->master_profit['services'] + $shift->master_profit['bar'], 0, '.', ' ') }} р.</td>
                    </tr>

                    @php
                        $commissions += $shift->master_profit['programs'];
                        $programs += $shift->master_profit['services'];
                        $total += ($shift->master_profit['programs'] + $shift->master_profit['services'] + $shift->master_profit['bar']);
                    @endphp
                @empty
                    <tr>
                        <td colspan="4">
                            <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ ('Вы не выходили в смену за последний месяц') }}</div>
                        </td>
                    </tr>
                @endforelse

                <tr><td colspan="4"></td></tr>

                <tr>
                    <td class="text-end">{{ __('За месяц') }}</td>
                    <td class="text-end">{{ number_format($commissions, 0, '.', ' ') }} р.</td>
                    <td class="text-end">{{ number_format($programs, 0, '.', ' ') }} р.</td>
                    <td class="text-end">{{ number_format($total, 0, '.', ' ') }} р.</td>
                </tr>
                </tbody>
            </table>

        </div>
        <div class="card-footer bg-light border-0"></div>
    </div>
@endsection
