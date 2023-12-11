@php
    use App\Http\Services\Helper;
    use Illuminate\Support\Facades\Gate;
@endphp

@extends('layouts.app')

@section('title', 'Проданная программа' . ' : ' . $seance->program->title)

@section('content')
    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Проданная программа') }} {{ $seance->program->title }}</div>

        <div class="card-body bg-light">
            <table class="table table-striped table-borderless">
                <tbody>
                    <tr>
                        <th class="text-start">{{ __('Программа') }}</th>
                        <td class="text-end">{{ $seance->program->title }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Начало программы') }}</th>
                        <td class="text-end">{{ date('d.m.Y H:i', $seance->open_time) }}</a></td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Окончание программы') }}</th>
                        <td class="text-end">{{ date('d.m.Y H:i', $seance->close_time) }}</a></td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Стоимость по прайсу') }}</th>
                        <td class="text-end">{{ number_format($seance->program->price, 2, '.', ' ') }}р.</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Корректировка стоимости') }}</th>
                        <td class="text-end">{{ is_null($seance->handle_price) ? ' - ' : number_format($seance->handle_price, 2, '.', ' ') . ' р.' }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Статус') }}</th>
                        <td class="text-end">{{ Helper::seanceStatus($seance->status) }}</td>
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

            <div class="accordion mb-3">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button bg-light text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            {{ __('Дополнительные услуги') }}
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <table class="table table-bordered">
                                <tbody>
                                @forelse($seance->services as $service)
                                    <tr>
                                        <td class="text-end" style="width: 60px">{{ $loop->iteration }}</td>
                                        <td class="text-start"><a href="{{ route('shift.service.show', $service->record_id) }}" target="_blank">{{ $service->service->title }}</a></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="text-start">{{ __('Дополнительно ничего не приобреталось') }}</td></tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>>
            </div>

            <div class="accordion mb-3">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button bg-light text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            {{ __('Напитки в баре') }}
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <table class="table table-bordered">
                                <tbody>
                                @forelse($seance->bar as $item)
                                    <tr>
                                        <td class="text-end" style="width: 60px">{{ $loop->iteration }}</td>
                                        <td class="text-start"><a href="{{ route('shift.bar.show', $item->record_id) }}" target="_blank">{{ $item->bar->title }} ({{ $item->bar->portion }})</a></td>
                                    </tr>
                                @empty
                                    <tr><td colspan="2" class="text-start">{{ __('Дополнительно ничего не приобреталось') }}</td></tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>>
            </div>

            <form method="post" action="{{ route('shift.program.destroy', $seance->seance_id) }}">
                @csrf
                @method('DELETE')

                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('shift.index') }}" class="btn btn-secondary me-1 rounded">{{ __('К смене') }}</a>
                    <a href="{{ route('shift.program.edit', $seance->seance_id) }}" class="btn btn-warning me-1 rounded">{{ __('Изменить') }}</a>
                    @if(Gate::allows('owner'))
                        <button type="submit" title="Delete" onclick="return confirm('{{ __('Вы уверены, что хотите удалить продажу программы?') }}')" class="btn btn-danger me-1 rounded">{{ __('Удалить') }}</button>
                    @endif
                </div>
            </form>
        </div>
    </div>
@endsection
