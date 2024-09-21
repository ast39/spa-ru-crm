@php

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
                <tr>
                    <th class="text-start">{{ __('Оплачено сертификатами') }}</th>
                    <td class="text-end">{{ number_format($report->cert_profit, 0, '.', ' ') }} {{ __('р.') }}</td>
                </tr>
                <tr>
                    <th class="text-start">{{ __('Программа скидок') }}</th>
                    <td class="text-end">-{{ number_format($report->sale_sum, 0, '.', ' ') }} р.</td>
                </tr>

                <tr><td colspan="2" class="bg-light text-center text-success"></td></tr>

                <tr>
                    <th class="text-start">{{ __('Выручка смены') }}</th>
                    <td class="text-end">{{ number_format($report->cash_profit + $report->card_profit + $report->phone_profit, 0, '.', ' ') }} {{ __('р.') }}</td>
                </tr>

                <tr><td colspan="2" class="bg-light text-center text-danger"><b>{{ __('Расходы') }}</b></td></tr>

                @forelse($report->shift->admins_profits as $admin_id => $data)
                    <tr>
                        <th class="text-start">{{ __('Администратор:') }} {{ $data['name'] }}</th>
                        <td class="text-end">-{{ number_format($data['profit'], 0, '.', ' ') }} {{ __('р.') }}</td>
                    </tr>
                @empty
                @endforelse

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
                                        <td>{{ __('Программа') }} "<a href="{{ route('dict.program.show', $program->program->program_id) }}">{{ $program->program->title }}</a>",
                                            мастер <a href="{{ route('dict.master.show', $program->master->id) }}">{{ $program->master->name }}</a>
                                            @if(!is_null($program->cover_master_id))
                                                , мастер <a href="{{ route('dict.master.show', $program->cover_master->id) }}">{{ $program->cover_master->name }}</a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        @if($program->seance_price_with_sale == 0)
                                            <td>{{ __('За счет заведения')  }}</td>
                                        @else
                                            <td>
                                                {{ __('Оплата') }}
                                                {{ number_format($program->seance_price_with_sale, 0, '.', ' ') }}{{ __('р.') }} [
                                                Нал: {{ number_format($program->cash_payed, 0, '.', ' ') }}{{ __('р.') }},
                                                Карта: {{ number_format($program->card_payed, 0, '.', ' ') }}{{ __('р.') }},
                                                Перевод: {{ number_format($program->phone_payed, 0, '.', ' ') }}{{ __('р.') }}
                                                ]
                                                {{ $program->sale_payed > 0 ? __('с учетом скидки') . ' ' . number_format($program->sale_payed, 0, '.', ' ') .  __('р.') : __('без скидки') }}</td>
                                        @endif
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
                                        <td>{{ __('Услуга') }} "<a href="{{ route('dict.service.show', $service->service->service_id) }}">{{ $service->service->title }}</a>",
                                            {{ __('мастер') }} <a href="{{ route('dict.master.show', $service->master->id) }}">{{ $service->master->name }}</a>
                                            @if(!is_null($service->cover_master_id))
                                                , мастер <a href="{{ route('dict.master.show', $service->cover_master->id) }}">{{ $service->cover_master->name }}</a>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        @if($service->service_price_with_sale == 0)
                                            <td>{{ __('За счет заведения')  }}</td>
                                        @else
                                            <td>
                                                {{ __('Оплата') }}
                                                {{ number_format($service->service_price_with_sale, 0, '.', ' ') }}{{ __('р.') }} [
                                                Нал: {{ number_format($service->cash_payed, 0, '.', ' ') }}{{ __('р.') }},
                                                Карта: {{ number_format($service->card_payed, 0, '.', ' ') }}{{ __('р.') }},
                                                Перевод: {{ number_format($service->phone_payed, 0, '.', ' ') }}{{ __('р.') }}
                                                ]
                                                {{ $service->sale_payed > 0 ? __('с учетом скидки') . ' ' . number_format($service->sale_payed, 0, '.', ' ') .  __('р.') : __('без скидки') }}</td>
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
                            {{ __('Товары') }}
                        </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                            <table class="table table-bordered">
                                <tbody>
                                @forelse($report->shift->bar as $item)
                                    <tr>
                                        <td rowspan="2" style="width: 100px"><a class="text-primary" href="{{ route('shift.bar.show', $item->record_id) }}">{{ date('H:i', $item->bar->created_at) }}</a></td>
                                        <td>{{ __('Товар') }} "<a href="{{ route('dict.bar.show', $item->bar->item_id) }}">{{ $item->bar->title }}</a>, {{ __('в кол-ве:') }} {{ $item->bar->portion }}</td>
                                    </tr>
                                    <tr>
                                        @if($item->bar_price_with_sale == 0)
                                            <td>{{ __('За счет заведения')  }}</td>
                                        @else
                                            <td>
                                                {{ __('Оплата') }}
                                                {{ number_format($item->bar_price_with_sale, 0, '.', ' ') }}{{ __('р.') }} [
                                                Нал: {{ number_format($item->cash_payed, 0, '.', ' ') }}{{ __('р.') }},
                                                Карта: {{ number_format($item->card_payed, 0, '.', ' ') }}{{ __('р.') }},
                                                Перевод: {{ number_format($item->phone_payed, 0, '.', ' ') }}{{ __('р.') }}
                                                ]
                                                {{ $item->sale_sum > 0 ? __('с учетом скидки') . ' ' . number_format($item->sale_payed, 0, '.', ' ') . __('р.') : __('без скидки') }}
                                            </td>
                                        @endif
                                    </tr>
                                    <tr><td colspan="2" class="bg-light"></td></tr>
                                @empty
                                    <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('Позиции товаров отсутствуют') }}</div>
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
