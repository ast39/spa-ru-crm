@php
    use App\Http\Services\Helper;
    use App\Http\Enums\PayType;
@endphp

@extends('layouts.app')

@section('title', __('Продажа') . ' : ' . __('Программа'))

@section('content')
    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Продажа') . ' : ' . __('Программа') }}</div>

        <div class="card-body bg-light">
            <form method="post" action="{{ route('shift.program.store') }}">
                @csrf
                @method('POST')

                <div class="mb-3">
                    <label for="admin_id" class="form-label required">{{ __('Администратор') }}</label>
                    <input type="text" class="form-control disabled" disabled id="admin_id" name="admin_id" value="{{ auth()->user()->name }}" />
                    @error('admin_id')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="master_id" class="form-label required">{{ __('Мастер') }}</label>
                    <select name="master_id" id="master_id" class="form-select form-control">
                        @foreach($masters as $master)
                            <option title="{{ $master->name }}" {{ request()->master_id == $master->id ? 'selected' : '' }} value="{{ $master->id }}">{{ $master->name }}</option>
                        @endforeach
                    </select>
                    @error('master_id')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="program_id" class="form-label required">{{ __('Программа') }}</label>
                    <select name="program_id" id="program_id" class="form-select form-control">
                        @foreach($programs as $program)
                            <option title="{{ $program->title }}" {{ (request()->program_id ?? 0) == $program->program_id ? 'selected' : '' }} value="{{ $program->program_id }}">{{ $program->title }}</option>
                        @endforeach
                    </select>
                    @error('program')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button bg-light collapsed text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                {{ __('Дополнительные услуги') }}
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <table class="table table-bordered">
                                    <thead class="table-secondary">
                                    <tr>
                                        <th class="text-start">{{ __('Услуга') }}</th>
                                        <th class="text-center" style="width: 100px">{{ __('Объем') }}</th>
                                        <th class="text-center" style="width: 80px">{{ __('Кол-во') }}</th>
                                        <th class="text-center" style="width: 80px">{{ __('Подарок') }}</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @forelse($services as $service)
                                        <tr>
                                            <td class="text-start">{{ $service->title }}</td>
                                            <td class="text-center">{{ __('шт') }}</td>
                                            <td class="text-center cb">
                                                <input class="form-control" name="services[{{ $service->service_id }}][amount]" type="text" />
                                            </td>
                                            <td class="text-center cb">
                                                <input class="form-check-input" name="services[{{ $service->service_id }}][gift]" type="checkbox">
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>>
                </div>

                <div class="accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button bg-light collapsed text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                {{ __('Бар') }}
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <table class="table table-bordered">
                                    <thead class="table-secondary">
                                    <tr>
                                        <th class="text-start">{{ __('Напиток') }}</th>
                                        <th class="text-center" style="width: 100px">{{ __('Объем') }}</th>
                                        <th class="text-center" style="width: 80px">{{ __('Кол-во') }}</th>
                                        <th class="text-center" style="width: 80px">{{ __('Подарок') }}</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @forelse($bar as $item)
                                        <tr>
                                            <td class="text-start">{{ $item->title }}</td>
                                            <td class="text-center">{{ $item->portion }}</td>
                                            <td class="text-center cb">
                                                <input class="form-control" name="bar[{{ $item->item_id }}][amount]" type="text" />
                                            </td>
                                            <td class="text-center cb">
                                                <input class="form-check-input" name="bar[{{ $item->item_id }}][gift]" type="checkbox">
                                            </td>
                                        </tr>
                                    @empty
                                        <div class="text-center p-2 mb-2 bg-secondary bg-gradient text-white rounded">{{ __('Дополнительно ничего не приобреталось') }}</div>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>>
                </div>

                <div class="mb-3">
                    <label for="guest" class="form-label">{{ __('Гость') }}</label>
                    <input type="text" class="form-control" id="guest" name="guest" placeholder="{{ __('Имя гостя') }}" value="{{ old('guest') }}" />
                    @error('guest')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="open_time" class="form-label">{{ __('Начало программы') }}</label>
                    <div class="mmot-filterline__one mmot-inputwithico-left" data-input_clear_content>
                        <svg class="mmot-inputwithico-left__ico"><use xlink:href="#site-calendar"></use></svg>
                        <input type="datetime-local" class="form-control" id="open_time" name="open_time" placeholder="{{ __('Время начала') }}" onfocus="(this.showPicker())" data-input_clear value="{{ old('open_time') }}" >
                    </div>
                    @error('open_time')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="close_time" class="form-label">{{ __('Окончание программы') }}</label>
                    <div class="mmot-filterline__one mmot-inputwithico-left" data-input_clear_content>
                        <svg class="mmot-inputwithico-left__ico"><use xlink:href="#site-calendar"></use></svg>
                        <input type="datetime-local" class="form-control" id="close_time" name="close_time" placeholder="{{ __('Время окончания') }}" onfocus="(this.showPicker())" data-input_clear value="{{ old('close_time') }}" >
                    </div>
                    @error('close_time')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="handle_price" class="form-label">{{ __('Корректировка стоимости') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="handle_price" name="handle_price" placeholder="{{ __('Если стоимость не по прайсу') }}" value="{{ old('handle_price') }}" />
                        <span class="input-group-text">{{ __('руб.') }}</span>
                        @error('handle_price')
                            <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="sale" class="form-label">{{ __('Скидка') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="sale" name="sale" placeholder="0" value="{{ old('sale') }}" />
                        <span class="input-group-text">{{ __('%') }}</span>
                        @error('sale')
                            <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="pay_type" class="form-label required">{{ __('Форма оплаты') }}</label>
                    <select name="pay_type" id="pay_type" class="form-select form-control">
                        <option title="Наличка" {{ (request()->pay_type ?? PayType::Cash->value) == PayType::Cash->value ? 'selected' : '' }} value="{{ PayType::Cash->value }}">{{ Helper::payType(PayType::Cash->value) }}</option>
                        <option title="Карта" {{ (request()->pay_type ?? PayType::Cash->value) == PayType::Card->value ? 'selected' : '' }} value="{{ PayType::Card->value }}">{{ Helper::payType(PayType::Card->value) }}</option>
                        <option title="Перевод" {{ (request()->pay_type ?? PayType::Cash->value) == PayType::Phone->value ? 'selected' : '' }} value="{{ PayType::Phone->value }}">{{ Helper::payType(PayType::Phone->value) }}</option>
                    </select>
                    @error('pay_type')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="from" class="form-label">{{ __('Откуда узнали') }}</label>
                    <input type="text" class="form-control" id="from" name="from" placeholder="{{ __('Какая реклама сработала') }}" value="{{ old('from') }}" />
                    @error('from')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="note" class="form-label">{{ __('Заметки') }}</label>
                    <textarea  cols="10" rows="5" class="form-control" id="note" placeholder="{{ __('Произвольные комментарии администратора') }}" name="note">{{ old('note') }}</textarea>
                    @error('note')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label required">{{ __('Статус') }}</label>
                    <select  class="form-control form-select" id="status" name="status">
                        <option title="Состоялся" value="1" {{ request()->status == 1 ? 'selected' : null }}>{{ __('Состоялся') }}</option>
                        <option title="Отмена" value="2" {{ request()->status == 2 ? 'selected' : null }}>{{ __('Отказ') }}</option>
                    </select>
                    @error('level')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('shift.index') }}" class="btn btn-secondary me-1 rounded">{{ __('Назад') }}</a>
                    <button type="submit" class="btn btn-primary rounded">{{ __('Добавить') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
