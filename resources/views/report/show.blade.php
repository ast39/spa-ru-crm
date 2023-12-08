@php
    use App\Http\Services\Helper;
@endphp

@extends('layouts.app')

@section('title', 'Отчет за смену' . ' : ' . $report->shift->title)

@section('content')
    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Отчет за смену' . ' : ' . $report->shift->title) }}</div>

        <div class="card-body bg-light">
            <table class="table table-striped table-borderless">
                <tbody>

                <tr><td colspan="2" class="bg-light text-center text-secondary"><b>{{ __('Смена') }}</b></td></tr>

                <tr>
                    <th class="text-start">{{ __('Смена') }}</th>
                    <td class="text-end">{{ $report->shift->title }}</td>
                </tr>
                <tr>
                    <th class="text-start">{{ __('Администратор открывший смену') }}</th>
                    <td class="text-end"><a href="{{ route('dict.admin.show', $report->shift->opened_admin_id) }}">{{ $report->shift->openedAdmin->name }}</a></td>
                </tr>
                <tr>
                    <th class="text-start">{{ __('Администратор закрывший смену') }}</th>
                    <td class="text-end"><a href="{{ route('dict.admin.show', $report->shift->closed_admin_id) }}">{{ $report->shift->closedAdmin->name }}</a></td>
                </tr>
                <tr>
                    <th class="text-start">{{ __('Количество гостей') }}</th>
                    <td class="text-end">{{ $report->clients }}</td>
                </tr>
                <tr>
                    <th class="text-start">{{ __('Комментарии по смене') }}</th>
                    <td class="text-end">{{ $report->additional }}</td>
                </tr>

                <tr><td colspan="2" class="bg-light text-center text-success"><b>{{ __('Доходы') }}</b></td></tr>

                <tr>
                    <th class="text-start">{{ __('Выручка за программы') }}</th>
                    <td class="text-end">{{ number_format($report->programs_profit, 0, '.', ' ') }} {{ __('р.') }}</td>
                </tr>
                <tr>
                    <th class="text-start">{{ __('Выручка за услуги') }}</th>
                    <td class="text-end">{{ number_format($report->services_profit, 0, '.', ' ') }} {{ __('р.') }}</td>
                </tr>
                <tr>
                    <th class="text-start">{{ __('Выручка за напитки') }}</th>
                    <td class="text-end">{{ number_format($report->bar_profit, 0, '.', ' ') }} {{ __('р.') }}</td>
                </tr>
                <tr><td colspan="2" class="bg-light text-center text-success"></td></tr>
                <tr>
                    <th class="text-start">{{ __('Выручка наличкой') }}</th>
                    <td class="text-end">{{ number_format($report->cash_profit, 0, '.', ' ') }} {{ __('р.') }}</td>
                </tr>
                <tr>
                    <th class="text-start">{{ __('Выручка безналом') }}</th>
                    <td class="text-end">{{ number_format($report->card_profit, 0, '.', ' ') }} {{ __('р.') }}</td>
                </tr>
                <tr>
                    <th class="text-start">{{ __('Выручка переводами') }}</th>
                    <td class="text-end">{{ number_format($report->phone_profit, 0, '.', ' ') }} {{ __('р.') }}</td>
                </tr>
                <tr><td colspan="2" class="bg-light text-center text-success"></td></tr>
                <tr>
                    <th class="text-start">{{ __('Выручка смены') }}</th>
                    <td class="text-end">{{ number_format($report->cash_profit + $report->card_profit + $report->phone_profit, 0, '.', ' ') }} {{ __('р.') }}</td>
                </tr>

                <tr><td colspan="2" class="bg-light text-center text-danger"><b>{{ __('Расходы') }}</b></td></tr>

                <tr>
                    <th class="text-start">{{ __('Администратор:') }} {{ $report->shift->openedAdmin->name }}</th>
                    <td class="text-end">-{{ number_format($report->admin_profit, 0, '.', ' ') }} {{ __('р.') }}</td>
                </tr>

                @forelse($report->shift->masters_profits as $master_id => $data)
                    <tr>
                        <th class="text-start">{{ __('Мастер:') }} {{ $data['name'] }}</th>
                        <td class="text-end">-{{ number_format($data['profit'], 0, '.', ' ') }} {{ __('р.') }}</td>
                    </tr>
                @empty
                @endforelse

                <tr>
                    <th class="text-start">{{ __('Хоз. расходы') }}</th>
                    <td class="text-end">-{{ number_format($report->expenses, 0, '.', ' ') }} {{ __('р.') }}</td>
                </tr>

                <tr>
                    <th class="text-start">{{ __('Программа скидок') }}</th>
                    <td class="text-end">-{{ number_format($report->sale_sum, 0, '.', ' ') }} р.</td>
                </tr>
                <tr><td colspan="2" class="bg-light text-center text-success"></td></tr>
                <tr>
                    <th class="text-start">{{ __('Издержки смены') }}</th>
                    <td class="text-end">{{ number_format(0 - $report->expenses - $report->admin_profit - $report->masters_profit - $report->sale_sum, 0, '.', ' ') }} {{ __('р.') }}</td>
                </tr>

                <tr><td colspan="2" class="bg-light text-center text-primary"><b>{{ __('Баланс') }}</b></td></tr>

                <tr>
                    <th class="text-start">{{ __('Сальдо по смене') }}</th>
                    <td class="text-end">{{ number_format(
                        $report->cash_profit + $report->card_profit + $report->phone_profit
                        - $report->admin_profit - $report->masters_profit - $report->expenses - $report->sale_sum,
                        0, '.', ' ') }} {{ __('р.') }}</td>
                </tr>
                <tr>
                    <th class="text-start">{{ __('Остаток в кассе') }}</th>
                    <td class="text-end">{{ number_format($report->stock, 0, '.', ' ') }} {{ __('р.') }}</td>
                </tr>

                </tbody>
            </table>

            <div class="accordion mb-3">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button bg-light text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            {{ __('Программы') }}
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <table class="table table-bordered">
                                <tbody>
                                @forelse($report->shift->programs as $program)
                                    <tr>
                                        <td rowspan="2" style="width: 100px"><a class="text-primary" href="{{ route('shift.program.show', $program->seance_id) }}">{{ date('H:i', $program->open_time) }}</a></td>
                                        <td>{{ __('Программа') }} "<a href="{{ route('dict.program.show', $program->program->program_id) }}">{{ $program->program->title }}</a>", мастер <a href="{{ route('dict.master.show', $program->master->id) }}">{{ $program->master->name }}</a></td>
                                    </tr>
                                    <tr>
                                        <td>{{ __('Оплата') }} {{ Helper::payType($program->pay_type) }} {{ number_format($program->total_price_with_sale, 0, '.', ' ') }} {{ __('р.') }}, {{ __('программа') }} {{ Helper::seanceStatus($program->status) }}, {{ $program->sale_sum > 0 ? __('с учетом скидки') . ' ' . number_format($program->sale_sum, 0, '.', ' ') . __('р.') : __('без скидки') }}</td>
                                    </tr>
                                    <tr><td colspan="2" class="bg-light"></td></tr>
                                @empty
                                    <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('Программы отсутствуют') }}</div>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion mb-3">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingTwo">
                        <button class="accordion-button bg-light text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                            {{ __('Услуги') }}
                        </button>
                    </h2>
                    <div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <table class="table table-bordered">
                                <tbody>
                                @forelse($report->shift->services as $service)
                                    <tr>
                                        <td rowspan="2" style="width: 100px"><a class="text-primary" href="{{ route('shift.service.show', $service->record_id) }}">{{ date('H:i', $service->service->created_at) }}</a></td>
                                        <td>{{ __('Услуга') }} "<a href="{{ route('dict.service.show', $service->service->service_id) }}">{{ $service->service->title }}</a>", {{ __('мастер') }} <a href="{{ route('dict.master.show', $service->master->id) }}">{{ $service->master->name }}</a>, {{ __('в кол-ве:') }} {{ $service->amount }}</td>
                                    </tr>
                                    <tr>
                                        @if($service->gift > 0)
                                            <td>{{ __('За счет заведения')  }}</td>
                                        @else
                                            <td>{{ __('Оплата') }} {{ Helper::payType($service->pay_type) }} {{ number_format($service->total_price_with_sale, 0, '.', ' ') }} р, {{ $service->sale_sum > 0 ? __('с учетом скидки') . ' ' . number_format($service->sale_sum, 0, '.', ' ') .  __('р.') : __('без скидки') }}</td>
                                        @endif
                                    </tr>
                                    <tr><td colspan="2" class="bg-light"></td></tr>
                                @empty
                                    <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('Услуги отсутствуют') }}</div>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="accordion mb-3">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingThree">
                        <button class="accordion-button bg-light text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">
                            {{ __('Бар') }}
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <table class="table table-bordered">
                                <tbody>
                                @forelse($report->shift->bar as $item)
                                    <tr>
                                        <td rowspan="2" style="width: 100px"><a class="text-primary" href="{{ route('shift.bar.show', $item->record_id) }}">{{ date('H:i', $item->bar->created_at) }}</a></td>
                                        <td>{{ __('Напиток') }} "<a href="{{ route('dict.bar.show', $item->bar->item_id) }}">{{ $item->bar->title }}</a>, {{ __('в кол-ве:') }} {{ $item->bar->portion }} x {{ $item->amount }}</td>
                                    </tr>
                                    <tr>
                                        @if($item->gift > 0)
                                            <td>{{ __('За счет заведения')  }}</td>
                                        @else
                                            <td>{{ __('Оплата') }} {{ Helper::payType($item->pay_type) }} {{ number_format($item->total_price_with_sale, 0, '.', ' ') }} {{ __('р.') }}, {{ $item->sale_sum > 0 ? __('с учетом скидки') . ' ' . number_format($item->sale_sum, 0, '.', ' ') . __('р.') : __('без скидки') }}</td>
                                        @endif
                                    </tr>
                                    <tr><td colspan="2" class="bg-light"></td></tr>
                                @empty
                                    <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('Позиции бара отсутствуют') }}</div>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="card-footer bg-light border-0"></div>
    </div>
@endsection
