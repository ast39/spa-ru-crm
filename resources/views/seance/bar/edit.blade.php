@php
    use App\Http\Services\Helper;
    use App\Http\Enums\PayType;
@endphp

@extends('layouts.app')

@section('title', __('Продажа') . ' : ' . __('Напитки'))


@section('content')
    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Продажа') . ' : ' . __('Напитки') }}</div>

        <div class="card-body bg-light">
            <form method="post" action="{{ route('shift.bar.update', $seance->record_id) }}">
                @csrf
                @method('PUT')

                <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane" aria-selected="false">Напиток</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="home-tab" data-bs-toggle="tab" data-bs-target="#home-tab-pane" type="button" role="tab" aria-controls="home-tab-pane" aria-selected="true">Персонал</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact-tab-pane" type="button" role="tab" aria-controls="contact-tab-pane" aria-selected="false">Финансы</button>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">
                    {{-- Вкладка : Напиток --}}
                    <div class="tab-pane fade show active" id="profile-tab-pane" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">
                        {{-- Напиток --}}
                        <div class="mb-3">
                            <label for="item_id" class="form-label required">{{ __('Напиток') }}</label>
                            <select name="item_id" id="item_id" class="form-select form-control">
                                @foreach($bar as $item)
                                    <option title="{{ $item->price }}" {{ ($seance->bar_id ?? 0) == $item->item_id ? 'selected' : '' }} value="{{ $item->item_id }}">
                                        {{ $item->title }} {{ $item->portion }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Гость --}}
                        <div class="mb-3">
                            <label for="guest" class="form-label">{{ __('Гость') }}</label>
                            <input type="text" class="form-control" id="guest" name="guest" placeholder="{{ __('Имя гостя') }}" value="{{ $seance->guest }}" />
                        </div>

                        {{-- Заметки --}}
                        <div class="mb-3">
                            <label for="note" class="form-label">{{ __('Заметки') }}</label>
                            <textarea  cols="10" rows="5" class="form-control" id="note" name="note">{{ $seance->note }}</textarea>
                        </div>
                    </div>

                    {{-- Вкладка : Персонал --}}
                    <div class="tab-pane fade" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        {{-- Администратор --}}
                        <div class="mb-3">
                            <label for="admin_id" class="form-label required">{{ __('Администратор') }}</label>
                            <input type="text" class="form-control disabled" disabled id="admin_id" name="admin_id" value="{{ $seance->admin->name }}" />
                        </div>

                        {{-- Процент администратора --}}
                        <div class="mb-3">
                            <label for="admin_percent" class="form-label required">{{ __('% администратора') }}</label>
                            <div class="input-group">
                                <button class="btn btn-danger btn-decrement" style="width: 36px" type="button">-</button>
                                <input type="text" class="form-control text-center percent-input" name="admin_percent" value="{{ round($seance->admin_percent) }}" readonly />
                                <button class="btn btn-success btn-increment" style="width: 36px" type="button">+</button>
                            </div>
                        </div>
                    </div>

                    {{-- Вкладка : Финансы --}}
                    <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                        {{-- Корректировка цены --}}
                        <div class="mb-3">
                            <label for="handle_price" class="form-label required">{{ __('Цена по прайсу') }}</label>
                            <div class="input-group">
                                <button class="btn btn-danger btn-decrement" style="width: 36px" type="button">-</button>
                                <input type="text" class="form-control text-center percent-input" id="handle_price" name="handle_price" value="{{ round($seance->handle_price ?? 0) }}" readonly />
                                <span class="input-group-text">{{ __('руб.') }}</span>
                                <button class="btn btn-success btn-increment" style="width: 36px" type="button">+</button>
                            </div>
                        </div>

                        {{-- Скидка --}}
                        <div class="mb-3">
                            <label for="sale_payed" class="form-label required">{{ __('Скидка') }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="sale_payed" name="sale_payed" placeholder="0" value="{{ round($seance->sale_payed) }}" />
                                <span class="input-group-text">{{ __('руб.') }}</span>
                            </div>
                        </div>

                        {{-- Внесено наличными --}}
                        <div class="mb-3">
                            <label for="sale" class="form-label required">{{ __('Оплачено наличными') }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="cash_payed" name="cash_payed" value="{{ round($seance->cash_payed) }}" />
                                <span class="input-group-text">{{ __('руб.') }}</span>
                            </div>
                        </div>

                        {{-- Внесено картой --}}
                        <div class="mb-3">
                            <label for="sale" class="form-label required">{{ __('Оплачено картой') }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="card_payed" name="card_payed" value="{{ round($seance->card_payed) }}" />
                                <span class="input-group-text">{{ __('руб.') }}</span>
                            </div>
                        </div>

                        {{-- Внесено переводом --}}
                        <div class="mb-3">
                            <label for="sale" class="form-label required">{{ __('Оплачено переводом') }}</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="phone_payed" name="phone_payed" value="{{ round($seance->phone_payed) }}" />
                                <span class="input-group-text">{{ __('руб.') }}</span>
                            </div>
                        </div>

                        {{-- Внесено сертификатом --}}
                        <div class="mb-3">
                            <label for="sale" class="form-label required">{{ __('Оплачено сертификатом') }}</label>
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
            $('#service_id').change(function() {
                const selectedOption = $(this).find('option:selected');
                let price = selectedOption.attr('title');
                price = Math.floor(parseFloat(price));
                $('#handle_price').val(price);
            });
        });
    </script>
@endpush

