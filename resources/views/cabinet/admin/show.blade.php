@php
    use App\Http\Services\Helper;
@endphp

@extends('layouts.app')

@section('title', __('Кабинет администратора') . ' : ' . $user->name)

@section('content')
    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Кабинет администратора') . ' : ' . $user->name }}</div>

        <div class="card-body bg-light">

            <table class="table table-bordered">
                <thead class="table-secondary">
                <tr>
                    <th class="text-start">{{ __('Смена') }}</th>
                    <th class="text-end">{{ __('% администратора') }}</th>
                    <th class="text-end">{{ __('% с программ') }}</th>
                    <th class="text-end">{{ __('Заработок') }}</th>
                </tr>
                </thead>

                <tbody>
                @php
                    $commissions = $programs = $total = 0;
                @endphp

                @forelse($shifts as $shift)
                    @php
                        $admin_profit = $shift->opened_admin_id != $user->id
                            ? 0
                            : $shift->admin_profit;
                        $master_profit = $shift->masters_profits[$user->id]['profit'] ?? 0;
                    @endphp

                    @if (is_null($master_profit) && $admin_profit == 0)
                        @continue
                    @endif

                    <tr>
                        <td class="text-start">{{ $shift->title }}</td>
                        <td class="text-end">{{ number_format($admin_profit, 0, '.', ' ') }} {{ __('р.') }}</td>
                        <td class="text-end">{{ number_format($master_profit, 0, '.', ' ') }} {{ __('р.') }}</td>
                        <td class="text-end">{{ number_format($admin_profit + $master_profit, 0, '.', ' ') }} р.</td>
                    </tr>

                    @php
                        $commissions += $admin_profit;
                        $programs += $master_profit;
                        $total += ($admin_profit + $master_profit);
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
                    <td class="text-end">{{ number_format($commissions, 0, '.', ' ') }} {{ __('р.') }}</td>
                    <td class="text-end">{{ number_format($programs, 0, '.', ' ') }} {{ __('р.') }}</td>
                    <td class="text-end">{{ number_format($total, 0, '.', ' ') }} {{ __('р.') }}</td>
                </tr>
                </tbody>
            </table>

        </div>
        <div class="card-footer bg-light border-0"></div>
    </div>
@endsection
