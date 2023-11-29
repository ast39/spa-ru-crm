@php
    use App\Http\Services\Helper;
    use App\Http\Services\ShiftHelper;
@endphp

@extends('layouts.app')

@section('title', 'Сеансы')

@section('content')
    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Сеансы') }}</div>

        <div class="card-body bg-light">

            <!-- Фильтр -->
            <div class="mmot-margin20">
                @include('components/filters/seances')
            </div>

            {{-- Других смен еще не было --}}
            @if(ShiftHelper::firstShift())

                {{-- Можно открыть новую смену --}}
                <form method="post" action="{{ route('shift.open') }}" class="admin-table__nomargin mb-3">
                    @csrf
                    @method('POST')

                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <button type="submit" class="btn btn-primary me-1 rounded">{{ __('Открыть смену') }}</button>
                    </div>
                </form>

            {{-- Другие смены уже были --}}
            @else

                {{-- Последняя смена не закрыта --}}
                @if(ShiftHelper::notClosedLastShift())

                    {{-- Последняя смена - это текущая смена --}}
                    @if(ShiftHelper::lastShiftIsCurrentShift())

                        {{-- Инструменты управления сменой --}}
                        <table class="table table-bordered">
                            <tbody>
                            @forelse($seances as $seance)
                                <tr>
                                    <td rowspan="2"><a class="text-primary" href="{{ route('seance.program.show', $seance->seance_id) }}">{{ date('H:i', $seance->open_time) }}</a><br />(Основная программа)</td>
                                    <td colspan="3">Программа "<a href="{{ route('dict.program.show', $seance->program->program_id) }}">{{ $seance->program->title }}</a>", мастер <a href="{{ route('dict.master.show', $seance->master->id) }}">{{ $seance->master->name }}</a></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Оплата {{ Helper::payType($seance->pay_type) }} {{ number_format($seance->total_price, 0, '.', ' ') }} р., программа {{ Helper::seanceStatus($seance->status) }}</td>
                                    <td colspan="3" class="text-end">
                                        <form method="post" action="{{ route('seance.program.destroy', $seance->seance_id) }}" class="admin-table__nomargin">
                                            @csrf
                                            @method('DELETE')

                                            <div class="mmot-table__action">
                                                <a title="Показать" href="{{ route('seance.program.show', $seance->seance_id) }}" class="mmot-table__action__one"><svg class="mmot-table_view mmot-table__ico"><use xlink:href="#site-view"></use></svg></a>
                                                <a title="Изменить" href="{{ route('seance.program.edit', $seance->seance_id) }}" class="mmot-table__action__one"><svg class="mmot-table_view mmot-table__ico"><use xlink:href="#site-edit"></use></svg></a>
                                                @if(Gate::allows('root-user'))
                                                    <button title="Удалить" type="submit" class="mmot-table__action__one" onclick="return confirm('Вы уверены, что хотите удалить сеанс?')"><svg class="mmot-table__delete mmot-table__ico"><use xlink:href="#site-delete"></use></svg></button>
                                                @endif
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                <tr><td colspan="5" class="bg-light"></td></tr>
                            @empty
                            @endforelse

                            </tbody>
                        </table>

                        <table class="table table-bordered">
                            <tbody>
                            @forelse($services as $service)
                                <tr>
                                    <td rowspan="2"><a class="text-primary" href="{{ route('seance.service.show', $service->record_id) }}">{{ date('H:i', $service->created_at) }}</a><br />(Доп. Услуга)</td>
                                    <td colspan="3">Услуга "<a href="{{ route('dict.service.show', $service->service->service_id) }}">{{ $service->service->title }}</a>", мастер <a href="{{ route('dict.master.show', $service->master->id) }}">{{ $service->master->name }}</a></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Оплата {{ Helper::payType($service->pay_type) }} {{ number_format($service->service->price, 0, '.', ' ') }} р</td>
                                    <td colspan="3" class="text-end">
                                        <form method="post" action="{{ route('seance.service.destroy', $service->service_id) }}" class="admin-table__nomargin">
                                            @csrf
                                            @method('DELETE')

                                            <div class="mmot-table__action">
                                                <button title="Удалить" type="submit" class="mmot-table__action__one" onclick="return confirm('Вы уверены, что хотите удалить услугу?')"><svg class="mmot-table__delete mmot-table__ico"><use xlink:href="#site-delete"></use></svg></button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                <tr><td colspan="5" class="bg-light"></td></tr>
                            @empty
                            @endforelse
                            </tbody>
                        </table>

                        <table class="table table-bordered">
                            <tbody>
                            @forelse($bar as $item)
                                <tr>
                                    <td rowspan="2"><a class="text-primary" href="{{ route('seance.bar.show', $item->record_id) }}">{{ date('H:i', $item->created_at) }}</a><br />(Напиток с бара)</td>
                                    <td colspan="3">Товар "<a href="{{ route('dict.bar.show', $item->bar->item_id) }}">{{ $item->bar->title }}</a>", в объеме {{ $item->bar->portion }} {{ $item->amount }} {{ Helper::num2word($item->amount, ['раз', 'раза', 'раз']) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">Оплата {{ Helper::payType($item->pay_type) }} {{ number_format($item->total_price, 0, '.', ' ') }} р</td>
                                    <td colspan="3" class="text-end">
                                        <form method="post" action="{{ route('seance.bar.destroy', $item->item_id) }}" class="admin-table__nomargin">
                                            @csrf
                                            @method('DELETE')

                                            <div class="mmot-table__action">
                                                <button title="Удалить" type="submit" class="mmot-table__action__one" onclick="return confirm('Вы уверены, что хотите удалить покупку?')"><svg class="mmot-table__delete mmot-table__ico"><use xlink:href="#site-delete"></use></svg></button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                                <tr><td colspan="5" class="bg-light"></td></tr>
                            @empty
                            @endforelse
                            </tbody>
                        </table>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-center mb-3">
                            <a href="{{ route('seance.program.create') }}" class="btn btn-primary rounded me-1">{{ __('Продать программу') }}</a>
                            <a href="{{ route('seance.service.create') }}" class="btn btn-primary rounded me-1">{{ __('Продать услуги') }}</a>
                            <a href="{{ route('seance.bar.create') }}" class="btn btn-primary rounded me-1">{{ __('Продать напитки') }}</a>
                        </div>

                        <div class="accordion mb-3">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button class="accordion-button bg-light text-secondary collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">{{ __('Закрыть смену') }}</button>
                                </h2>
                                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                     data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <form method="post" action="{{ route('report.store') }}" class="admin-table__nomargin">
                                            @csrf
                                            @method('POST')

                                            <div class="mb-3">
                                                <input type="text" class="form-control" name="expenses" placeholder="Расходы"/>
                                            </div>
                                            <textarea style="width: 100%; height: 120px" class="form-control mb-2" name="additional" placeholder="Заметки по смене"></textarea>
                                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                                <button title="Закрыть смену" type="submit" class="btn btn-danger me-1 rounded" onclick="return confirm('Вы уверены, что хотите закрыть смену?')">Закрыть смену</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                    {{-- Уже время новой смены, а старая смена не закрыта --}}
                    @else

                        {{-- Нужно закрыть старую смену --}}
                        <div class="text-center p-2 mb-2 bg-danger bg-gradient text-white rounded">{{ __('Вы забыли закрыть предыдущую смену. Давайте закроем ее сейчас.') }}</div>
                        <form method="post" action="{{ route('shift.close') }}" class="admin-table__nomargin mb-3">
                            @csrf
                            @method('POST')

                            <div class="mb-3">
                                <input type="text" class="form-control" name="expenses" placeholder="{{ __('Расходы') }}"/>
                            </div>
                            <textarea style="width: 100%; height: 120px" class="form-control mb-2" name="additional" placeholder="{{ __('Заметки по смене') }}"></textarea>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <button title="Закрыть смену" type="submit" class="btn btn-danger me-1 rounded" onclick="return confirm('{{ __('Вы уверены, что хотите закрыть смену?') }}')">{{ __('Закрыть смену') }}</button>
                            </div>
                        </form>

                    @endif

                {{-- Последняя смена закрыта --}}
                @else

                    {{-- Последняя смена - это текущая смена --}}
                    @if(ShiftHelper::lastShiftIsCurrentShift())

                        {{-- Ждем следующей смены --}}
                        <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('Смена уже закрыта, новую можно открыть не ранее 11:00') }}</div>

                    {{-- Уже время новой смены и страрая смена закрыта --}}
                    @else

                        {{-- Можно открыть новую смену --}}
                        <form method="post" action="{{ route('shift.open') }}">
                            @csrf
                            @method('POST')

                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                <button type="submit" title="Delete" onclick="return confirm('{{ __('"Вы уверены, что хотите открыть новую смену?') }}')" class="btn btn-primary me-1 rounded">{{ __('Открыть смену') }}</button>
                            </div>
                        </form>

                    @endif

                @endif

            @endif

        </div>
        <div class="card-footer bg-light border-0"></div>
    </div>
@endsection
