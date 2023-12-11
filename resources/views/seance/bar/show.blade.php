@php
    use App\Http\Services\Helper;
@endphp

@extends('layouts.app')

@section('title', 'Проданный напиток ' . $seance->bar->title)

@section('content')
    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Проданный напиток') }} {{ $seance->bar->title }}</div>

        <div class="card-body bg-light">
            <table class="table table-striped table-borderless">
                <tbody>
                    <tr>
                        <th class="text-start">{{ __('Напиток') }}</th>
                        <td class="text-end">{{ $seance->bar->title }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Порция') }}</th>
                        <td class="text-end">{{ $seance->bar->portion }}</a></td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Стоимость') }}</th>
                        <td class="text-end">{{ number_format($seance->bar->price, 2, '.', ' ') }}{{ __('р.') }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Кол-во') }}</th>
                        <td class="text-end">{{ $seance->amount }}</a></td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Общая стоимость') }}</th>
                        <td class="text-end">{{ number_format($seance->bar->price * $seance->amount, 2, '.', ' ') }}{{ __('р.') }}</td>
                    </tr>

                    <tr><td colspan="2" class="bg-light">&nbsp</td></tr>

                    <tr>
                        <th class="text-start">{{ __('Гость') }}</th>
                        <td class="text-end">{{ empty($seance->guest) ? 'Гость' : $seance->guest }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Скидка') }} {{ $seance->sale > 0 ? $seance->sale . '%' : '' }}</th>
                        <td class="text-end">{{ $seance->sale > 0 ? number_format($seance->sale_sum, 0, '.', ' ') . __('р.') : __('Без скидки')  }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Форма оплаты') }}</th>
                        <td class="text-end">{{ Helper::payType($seance->pay_type) }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Откуда узнали') }}</th>
                        <td class="text-end">{{ empty($seance->from) ? ' - ' : $seance->from }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Итого с гостя') }}</th>
                        <td class="text-end">{{ number_format($seance->total_price_with_sale, 0, '.', ' ') }} {{ __('р.') }}</td>
                    </tr>

                    <tr><td colspan="2" class="bg-light">&nbsp</td></tr>

                    <tr>
                        <th class="text-start">{{ __('Администратор') }}</th>
                        <td class="text-end">{{ $seance->admin->name }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Заработок администратора') }}</th>
                        <td class="text-end">{{ number_format($seance->admin_profit, 2, '.', ' ') }} {{ __('р.') }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Заработок компании') }}</th>
                        <td class="text-end">{{ number_format($seance->total_price_with_sale - $seance->admin_profit, 2, '.', ' ') }} {{ __('р.') }}</td>
                    </tr>

                    <tr><td colspan="2" class="bg-light">&nbsp</td></tr>

                    <tr>
                        <th class="text-start">{{ __('Заметки') }}</th>
                        <td class="text-end">{{ empty($seance->note) ? ' - ' : $seance->note }}</td>
                    </tr>
                </tbody>
            </table>

            <form method="post" action="{{ route('shift.bar.destroy', $seance->record_id) }}">
                @csrf
                @method('DELETE')

                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('shift.index') }}" class="btn btn-secondary me-1 rounded">{{ __('К смене') }}</a>
                    <a href="{{ route('shift.bar.edit', $seance->record_id) }}" class="btn btn-warning me-1 rounded">{{ __('Изменить') }}</a>
                    <button type="submit" title="Delete" onclick="return confirm('{{ __('Вы уверены, что хотите удалить продажу напитка?') }}')" class="btn btn-danger me-1 rounded">{{ __('Удалить') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
