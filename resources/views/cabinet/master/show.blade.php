@php
    use App\Http\Services\Helper;
@endphp

@extends('layouts.app')

@section('title', __('Кабинет мастера') . ' : ' . $user->name)

@section('content')
    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Кабинет мастера') . ' : ' . $user->name }}</div>

        <div class="card-body bg-light">

            <table class="table table-bordered">
                <thead class="table-secondary">
                <tr>
                    <th class="text-start">{{ __('Смена') }}</th>
                    <th class="text-end">{{ __('Заработок') }}</th>
                </tr>
                </thead>

                <tbody>
                @php
                    $total = 0;
                @endphp

                @forelse($shifts as $shift)
                    @php
                        $master_profit = $shift->masters_profits[$user->id] ?? null;
                    @endphp

                    @if (is_null($master_profit))
                        @continue
                    @endif

                    <tr>
                        <td class="text-start">{{ $shift->title }}</td>
                        <td class="text-end">{{ number_format($master_profit['profit'], 0, '.', ' ') }} {{ __('р.') }}</td>
                    </tr>

                    @php
                        $total += $master_profit['profit'];
                    @endphp
                @empty
                    <tr>
                        <td colspan="2">
                            <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ ('Вы не выходили в смену за последний месяц') }}</div>
                        </td>
                    </tr>
                @endforelse

                <tr><td colspan="2"></td></tr>

                <tr>
                    <td class="text-end">{{ __('За месяц') }}</td>
                    <td class="text-end">{{ number_format($total, 0, '.', ' ') }} {{ __('р.') }}</td>
                </tr>
                </tbody>
            </table>

        </div>
        <div class="card-footer bg-light border-0"></div>
    </div>
@endsection
