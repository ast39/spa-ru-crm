@php
    use App\Http\Services\Helper;
@endphp

@extends('layouts.app')

@section('title', 'Проданный товар ' . $seance->bar->title)


@section('content')
    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Проданный товар') }} {{ $seance->bar->title }}</div>

        <div class="card-body bg-light">
            <table class="table table-striped table-borderless">
                <tbody>
                    <tr>
                        <th class="text-start">{{ __('Товар') }}</th>
                        <td class="text-end">{{ $seance->bar->title }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Порция') }}</th>
                        <td class="text-end">{{ $seance->bar->portion }}</a></td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Стоимость по прайсу') }}</th>
                        <td class="text-end">{{ number_format($seance->bar->price, 0, '.', ' ') }} {{ __('р.') }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Фактическая стоимость') }}</th>
                        <td class="text-end">{{ number_format($seance->bar_price, 0, '.', ' ') . ' р.' }}</td>
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
                        <th class="text-start">{{ __('Оплата наличкой') }}</th>
                        <td class="text-end">{{ number_format($seance->cash_payed, 0, '.', ' ') }} р.</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Оплата картой') }}</th>
                        <td class="text-end">{{ number_format($seance->card_payed, 0, '.', ' ') }} р.</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Оплата переводом') }}</th>
                        <td class="text-end">{{ number_format($seance->phone_payed, 0, '.', ' ') }} р.</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Оплата сертификатом') }}</th>
                        <td class="text-end">{{ number_format($seance->cert_payed, 0, '.', ' ') }} р.</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Итого с гостя') }}</th>
                        <td class="text-end">{{ number_format($seance->service_price_with_sale, 0, '.', ' ') }} р.</td>
                    </tr>

                    <tr><td colspan="2" class="bg-light">&nbsp</td></tr>

                    <tr>
                        <th class="text-start">{{ __('Администратор') }}</th>
                        <td class="text-end">{{ $seance->admin->name }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Заработок администратора') }}</th>
                        <td class="text-end">{{ number_format($seance->admin_profit, 0, '.', ' ') }} р. ({{ number_format($seance->admin_percent) }}%)</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Заработок компании') }}</th>
                        <td class="text-end">{{ number_format($seance->owner_profit, 0, '.', ' ') }} {{ __('р.') }}</td>
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
        <div class="card-footer bg-light border-0"></div>
    </div>
@endsection
