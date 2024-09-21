@php

@endphp

@extends('layouts.app')

@section('title', __('Продажа') . ' : ' . __('Услуги'))


@section('content')
    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Продажа') . ' : ' . __('Услуги') }}</div>

        <div class="card-body bg-light">
            <form method="post" action="{{ route('shift.service.update', $seance->record_id) }}">
                @csrf
                @method('PUT')

                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Программа</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Исполнители</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Финансы</button>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    {{-- Вкладка : Услуга --}}
                    <div class="tab-pane fade show active" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        {{-- Услуга --}}
                        <div class="mb-3">
                            <label for="service_id" class="form-label required">{{ __('Услуга') }}</label>
                            <select name="service_id" id="service_id" class="form-select form-control">
                                @foreach($services as $service)
                                    <option title="{{ $service->title }}" {{ $seance->service->service_id == $service->service_id ? 'selected' : '' }} value="{{ $service->service_id }}">{{ $service->title }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Гость --}}
                        <div class="mb-3">
                            <label for="guest" class="form-label">{{ __('Гость') }}</label>
                            <input type="text" class="form-control" id="guest" name="guest" placeholder="{{ __('Имя гостя') }}" value="{{ $seance->guest }}" />
                        </div>

                        {{-- Начало услуги --}}
                        <div class="mb-3">
                            <label for="open_time" class="form-label">{{ __('Начало программы') }}</label>
                            <div class="mmot-filterline__one mmot-inputwithico-left" data-input_clear_content>
                                <svg class="mmot-inputwithico-left__ico"><use xlink:href="#site-calendar"></use></svg>
                                <input type="datetime-local" class="form-control" id="open_time" name="open_time" placeholder="Время начала" onfocus="(this.showPicker())" data-input_clear value="{{ date('Y-m-d', $seance->open_time) }}T{{ date('H:i', $seance->open_time) }}" >
                            </div>
                        </div>

                        {{-- Окончание услуги --}}
                        <div class="mb-3">
                            <label for="close_time" class="form-label">{{ __('Окончание программы') }}</label>
                            <div class="mmot-filterline__one mmot-inputwithico-left" data-input_clear_content>
                                <svg class="mmot-inputwithico-left__ico"><use xlink:href="#site-calendar"></use></svg>
                                <input type="datetime-local" class="form-control" id="close_time" name="close_time" placeholder="{{ __('Время окончания') }}" onfocus="(this.showPicker())" data-input_clear value="{{ date('Y-m-d', $seance->close_time) }}T{{ date('H:i', $seance->close_time) }}" >
                            </div>
                        </div>

                        {{-- Откуда узнали --}}
                        <div class="mb-3">
                            <label for="from" class="form-label">{{ __('Откуда узнали') }}</label>
                            <input type="text" class="form-control" id="from" name="from" placeholder="{{ __('Какая реклама сработала') }}" value="{{ $seance->from }}" />
                        </div>

                        {{-- Заметки --}}
                        <div class="mb-3">
                            <label for="note" class="form-label">{{ __('Заметки') }}</label>
                            <textarea  cols="10" rows="5" class="form-control" id="note" name="note">{{ $seance->note }}</textarea>
                        </div>

                        {{-- Статус --}}
                        <div class="mb-3">
                            <label for="status" class="form-label required">{{ __('Статус') }}</label>
                            <select  class="form-control form-select" id="status" name="status">
                                <option title="Состоялся" value="1" {{ $seance->status == 1 ? 'selected' : null }}>{{ __('Оказана') }}</option>
                                <option title="Отмена" value="2" {{ $seance->status == 2 ? 'selected' : null }}>{{ __('Отказ') }}</option>
                            </select>
                        </div>
                    </div>

                    {{-- Вкладка : Исполнители --}}
                    <div class="tab-pane fade" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        {{-- Администратор --}}
                        <div class="mb-3">
                            <label for="admin_id" class="form-label required">{{ __('Администратор') }}</label>
                            <input type="text" class="form-control disabled" disabled id="admin_id" name="admin_id" value="{{ $seance->admin->name }}" />
                        </div>

                        {{-- Процент администратора --}}
                        <div class="mb-3">
                            <label for="admin_percent" class="form-label">{{ __('% администратора') }}</label>
                            <div class="input-group">
                                <button class="btn btn-danger btn-decrement" style="width: 36px" type="button">-</button>
                                <input type="text" class="form-control text-center percent-input" name="admin_percent" value="{{ round($seance->admin_percent) }}" readonly />
                                <button class="btn btn-success btn-increment" style="width: 36px" type="button">+</button>
                            </div>
                        </div>

                        {{-- Основной мастер --}}
                        <div class="mb-3">
                            <label for="master_id" class="form-label required">{{ __('Мастер') }}</label>
                            <select name="master_id" id="master_id" class="form-select form-control">
                                @foreach($masters as $master)
                                    <option title="{{ $master->name }}" {{ $seance->master->id == $master->id ? 'selected' : '' }} value="{{ $master->id }}">{{ $master->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Процент основного мастера --}}
                        <div class="mb-3">
                            <label for="master_percent" class="form-label">{{ __('% основного мастера') }}</label>
                            <div class="input-group">
                                <button class="btn btn-danger btn-decrement" style="width: 36px" type="button">-</button>
                                <input type="text" class="form-control text-center percent-input" name="master_percent" value="{{ round($seance->master_percent) }}" readonly />
                                <button class="btn btn-success btn-increment" style="width: 36px" type="button">+</button>
                            </div>
                        </div>

                        {{-- Второй мастер --}}
                        <div class="mb-3">
                            <label for="cover_master_id" class="form-label">{{ __('Второй мастер') }}</label>
                            <select name="cover_master_id" id="cover_master_id" class="form-select form-control">
                                <option title="{{ __('Не предусмотрен') }}" {{ request()->cover_master_id == 0 ? 'selected' : '' }} value="0">{{ __('Не предусмотрен') }}</option>
                                @foreach($masters as $master)
                                    <option title="{{ $master->name }}" {{ $seance->cover_master_id == $master->id ? 'selected' : '' }} value="{{ $master->id }}">{{ $master->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Процент второго мастера --}}
                        <div class="mb-3">
                            <label for="cover_master_percent" class="form-label">{{ __('% второго мастера') }}</label>
                            <div class="input-group">
                                <button class="btn btn-danger btn-decrement disabled cover_master_percent" disabled style="width: 36px" type="button">-</button>
                                <input type="text" class="form-control text-center percent-input disabled cover_master_percent" disabled id="cover_master_percent" name="cover_master_percent" value="{{ round($seance->cover_master_percent) }}" readonly />
                                <button class="btn btn-success btn-increment disabled cover_master_percent" disabled style="width: 36px" type="button">+</button>
                            </div>
                        </div>
                    </div>

                    {{-- Вкладка : Финансы --}}
                    <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                        {{-- Корректировка цены --}}
                        <div class="mb-3">
                            <label for="handle_price" class="form-label required">{{ __('Корректировка цены') }}</label>
                            <div class="input-group">
                                <button class="btn btn-danger btn-decrement" style="width: 36px" type="button">-</button>
                                <input type="text" class="form-control text-center percent-input" id="handle_price" name="handle_price" value="{{ round($seance->handle_price ?? 0) }}" readonly />
                                <span class="input-group-text">{{ __('руб.') }}</span>
                                <button class="btn btn-success btn-increment" style="width: 36px" type="button">+</button>
                            </div>
                        </div>

                        {{-- Скидка --}}
                        <div class="mb-3">
                            <label for="sale_payed" class="form-label">{{ __('Скидка') }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="sale_payed" name="sale_payed" placeholder="0" value="{{ round($seance->sale_payed) }}" />
                                <span class="input-group-text">{{ __('руб.') }}</span>
                            </div>
                        </div>

                        {{-- Внесено наличными --}}
                        <div class="mb-3">
                            <label for="cash_payed" class="form-label">{{ __('Оплачено наличными') }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="cash_payed" name="cash_payed" value="{{ round($seance->cash_payed) }}" />
                                <span class="input-group-text">{{ __('руб.') }}</span>
                            </div>
                        </div>

                        {{-- Внесено картой --}}
                        <div class="mb-3">
                            <label for="card_payed" class="form-label">{{ __('Оплачено картой') }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="card_payed" name="card_payed" value="{{ round($seance->card_payed) }}" />
                                <span class="input-group-text">{{ __('руб.') }}</span>
                            </div>
                        </div>

                        {{-- Внесено переводом --}}
                        <div class="mb-3">
                            <label for="phone_payed" class="form-label">{{ __('Оплачено переводом') }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="phone_payed" name="phone_payed" value="{{ round($seance->phone_payed) }}" />
                                <span class="input-group-text">{{ __('руб.') }}</span>
                            </div>
                        </div>

                        {{-- Внесено сертификатом --}}
                        <div class="mb-3">
                            <label for="cert_payed" class="form-label">{{ __('Оплачено сертификатом') }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="cert_payed" name="cert_payed" value="{{ round($seance->cert_payed) }}" />
                                <span class="input-group-text">{{ __('руб.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('shift.index') }}" class="btn btn-secondary me-1 rounded">{{ __('Назад') }}</a>
                    <button type="submit" class="btn btn-primary rounded">{{ __('Сохранить') }}</button>
                </div>

                @if($errors->any())
                    <div class="text-center p-2 mb-3 mt-3 bg-danger bg-gradient text-white rounded">{{ $errors->first() }}</div>
                @endif
            </form>
        </div>

        <div class="card-footer bg-light border-0"></div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Диапазон процентов заработка
            var minPercent = 1;
            var maxPercent = 50;

            // Диапазон корректировки цен
            var minPrice = 0;
            var maxPrice = 50000;

            // Шаг цены
            var priceStep = 100;

            togglePercentField();
            $('#cover_master_id').change(function() {
                togglePercentField();
            });

            // Инкремент значений
            $('.btn-increment').click(function() {
                var input = $(this).siblings('.percent-input');
                var currentVal = parseInt(input.val());

                // Если это поле цены (name="handle_price"), шаг 100
                if (input.attr('name') === 'handle_price') {
                    if (currentVal < maxPrice && !input.prop('disabled')) {
                        input.val(currentVal + priceStep);
                    }
                } else {
                    if (currentVal < maxPercent && !input.prop('disabled')) {
                        input.val(currentVal + 1);
                    }
                }
            });

            // Декремент значений
            $('.btn-decrement').click(function() {
                var input = $(this).siblings('.percent-input');
                var currentVal = parseInt(input.val());

                // Если это поле цены (name="handle_price"), шаг 100
                if (input.attr('name') === 'handle_price') {
                    if (currentVal > minPrice && !input.prop('disabled')) {
                        input.val(currentVal - priceStep);
                    }
                } else {
                    if (currentVal > minPercent && !input.prop('disabled')) {
                        input.val(currentVal - 1);
                    }
                }
            });

            // Синхронизация цены относительно выбранной программы
            $('#program_id').change(function() {
                const selectedOption = $(this).find('option:selected');
                let price = selectedOption.attr('title');
                price = Math.floor(parseFloat(price));
                $('#handle_price').val(price);
            });

            // Контроль актуальности процента второго мастера
            function togglePercentField() {
                var selectedMaster = $('#cover_master_id').val();
                var percentInput = $('.cover_master_percent');

                if (selectedMaster === '0') {
                    percentInput.prop('disabled', true);
                    percentInput.addClass('disabled');
                } else {
                    percentInput.prop('disabled', false);
                    percentInput.removeClass('disabled');
                }
            }
        });
    </script>
@endpush
