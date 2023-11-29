@php
    use App\Http\Services\Helper;
    use Illuminate\Support\Facades\Gate;
@endphp

@extends('layouts.app')

@section('title', 'Проданная услуга ' . $seance->service->title)

@section('content')
    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Проданная услуга') }} {{ $seance->service->title }}</div>

        <div class="card-body bg-light">
            <table class="table table-striped table-borderless">
                <tbody>
                    <tr>
                        <th class="text-start">{{ __('Услуга') }}</th>
                        <td class="text-end">{{ $seance->service->title }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Стоимость') }}</th>
                        <td class="text-end">{{ number_format($seance->service->price, 2, '.', ' ') }}р.</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Кол-во') }}</th>
                        <td class="text-end">{{ $seance->amount }}</a></td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Общая стоимость') }}</th>
                        <td class="text-end">{{ number_format($seance->service->price * $seance->amount, 2, '.', ' ') }}р.</td>
                    </tr>

                    <tr><td colspan="2" class="bg-light">&nbsp</td></tr>

                    <tr>
                        <th class="text-start">{{ __('Гость') }}</th>
                        <td class="text-end">{{ empty($seance->guest) ? 'Гость' : $seance->guest }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Скидка') }} {{ $seance->sale > 0 ? $seance->sale . '%' : '' }}</th>
                        <td class="text-end">{{ $seance->sale > 0 ? number_format($seance->sale_sum, 0, '.', ' ') . ' р.' : 'Без скидки'  }}</td>
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
                        <td class="text-end">{{ number_format($seance->total_price_with_sale, 0, '.', ' ') }} р.</td>
                    </tr>

                    <tr><td colspan="2" class="bg-light">&nbsp</td></tr>

                    <tr>
                        <th class="text-start">{{ __('Администратор') }}</th>
                        <td class="text-end">{{ $seance->admin->name }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Заработок администратора') }}</th>
                        <td class="text-end">{{ number_format($seance->admin_profit, 2, '.', ' ') }} р.</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Мастер') }}</th>
                        <td class="text-end">{{ $seance->master->name }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Заработок мастера') }}</th>
                        <td class="text-end">{{ number_format($seance->master_profit, 2, '.', ' ') }} р.</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Заработок компании') }}</th>
                        <td class="text-end">{{ number_format($seance->total_price_with_sale - $seance->admin_profit - $seance->master_profit, 2, '.', ' ') }} р.</td>
                    </tr>

                    <tr><td colspan="2" class="bg-light">&nbsp</td></tr>

                    <tr>
                        <th class="text-start">{{ __('Заметки') }}</th>
                        <td class="text-end">{{ empty($seance->note) ? ' - ' : $seance->note }}</td>
                    </tr>
                </tbody>
            </table>

            <form method="post" action="{{ route('seance.service.destroy', $seance->record_id) }}">
                @csrf
                @method('DELETE')

                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('shift.index') }}" class="btn btn-secondary me-1 rounded">К смене</a>
                    <a href="{{ route('seance.service.edit', $seance->record_id) }}" class="btn btn-warning me-1 rounded">Изменить</a>
                    @if(Gate::allows('owner'))
                        <button type="submit" title="Delete" onclick="return confirm('Вы уверены, что хотите удалить продажу услуги?')" class="btn btn-danger me-1 rounded">Удалить</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection