@php

@endphp

@extends('layouts.app')

@section('title', __('Продажа') . ' : ' . __('Напитки'))

@section('content')
    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Продажа') . ' : ' . __('Напитки') }}</div>

        <div class="card-body bg-light">
            <form method="post" action="{{ route('shift.bar.store') }}">
                @csrf
                @method('POST')

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
                                    <option data-price="{{ $item->price }}" {{ (request()->bar_id ?? 0) == $item->item_id ? 'selected' : '' }} value="{{ $item->item_id }}">
                                        {{ $item->title }} {{ $item->portion }}
                                    </option>
                                @endforeach
                            </select>
                            @error('item_id')
                                <p class="text-danger mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Гость --}}
                        <div class="mb-3">
                            <label for="guest" class="form-label">{{ __('Гость') }}</label>
                            <input type="text" class="form-control" id="guest" name="guest" placeholder="{{ __('Имя гостя') }}" value="{{ old('guest') }}" />
                            @error('guest')
                                <p class="text-danger mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Заметки --}}
                        <div class="mb-3">
                            <label for="note" class="form-label">{{ __('Заметки') }}</label>
                            <textarea  cols="10" rows="5" class="form-control" id="note" name="note">{{ old('note') }}</textarea>
                            @error('note')
                                <p class="text-danger mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Вкладка : Персонал --}}
                    <div class="tab-pane fade" id="home-tab-pane" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
                        {{-- Администратор --}}
                        <div class="mb-3">
                            <label for="admin_id" class="form-label required">{{ __('Администратор') }}</label>
                            <input type="text" class="form-control disabled" disabled id="admin_id" name="admin_id" value="{{ auth()->user()->name }}" />
                            @error('admin_id')
                                <p class="text-danger mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Процент администратора --}}
                        <div class="mb-3">
                            <label for="admin_percent" class="form-label required">{{ __('% администратора') }}</label>
                            <div class="input-group">
                                <button class="btn btn-danger btn-decrement" style="width: 36px" type="button">-</button>
                                <input type="text" class="form-control text-center percent-input" name="admin_percent" value="{{ old('admin_percent', 10) }}" readonly />
                                <button class="btn btn-success btn-increment" style="width: 36px" type="button">+</button>
                            </div>
                            @error('admin_percent')
                                <p class="text-danger mt-2">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Вкладка : Финансы --}}
                    <div class="tab-pane fade" id="contact-tab-pane" role="tabpanel" aria-labelledby="contact-tab" tabindex="0">
                        <div class="mb-3">
                            <h3 class="text-secondary">Расчет</h3>
                        </div>

                        {{-- Базовая цена --}}
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text">Цена</span>
                                <input type="text" class="form-control text-end percent-input" id="handle_price" name="handle_price" value="{{ round($bar[0]->price) }}" readonly />
                                <span class="input-group-text">{{ __('руб.') }}</span>
                            </div>
                        </div>

                        {{-- Скидка --}}
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text">Скидка</span>
                                <input type="text" class="form-control text-end" readonly id="sale_payed" name="sale_payed" value="{{ old('sale_payed', 0) }}" />
                                <span class="input-group-text">{{ __('руб.') }}</span>
                            </div>
                        </div>

                        {{-- Коэффициент программы --}}
                        <div class="mb-3">
                            <label for="master_percent" class="form-label required">{{ __('Коэффициент') }}</label>
                            <div class="input-group">
                                <button class="btn btn-danger btn-decrement recalculate" style="width: 36px" type="button">-</button>
                                <input
                                    type="text"
                                    id="rate"
                                    class="form-control text-center percent-input"
                                    name="rate"
                                    value="{{ old('rate', 100) }}"
                                    readonly
                                    data-min="50"
                                    data-max="200"
                                    data-step="5"
                                />
                                <span class="input-group-text">{{ __('%') }}</span>
                                <button class="btn btn-success btn-increment recalculate" style="width: 36px" type="button">+</button>
                            </div>
                        </div>

                        {{-- Скидка --}}
                        <div class="mb-3">
                            <label for="master_percent" class="form-label required">{{ __('Скидка') }}</label>
                            <div class="input-group">
                                <button class="btn btn-danger btn-decrement recalculate" style="width: 36px" type="button">-</button>
                                <input
                                    type="text"
                                    id="sale_percent"
                                    class="form-control text-center percent-input"
                                    name="sale_percent"
                                    value="{{ old('sale_percent', 0) }}"
                                    readonly
                                    data-min="0"
                                    data-max="100"
                                    data-step="1"
                                />
                                <span class="input-group-text">{{ __('%') }}</span>
                                <button class="btn btn-success btn-increment recalculate" style="width: 36px" type="button">+</button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <h3 class="text-secondary">Оплата</h3>
                        </div>

                        {{-- Итого к оплате --}}
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text">К оплате</span>
                                <input type="text" class="form-control text-end percent-input" id="total" name="total" value="{{ old('total', round($bar[0]->price)) }}" readonly />
                                <span class="input-group-text">{{ __('руб.') }}</span>
                            </div>
                        </div>

                        {{-- Внесено наличными --}}
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text">Наличными</span>
                                <input type="text" class="form-control text-end" id="cash_payed" name="cash_payed" placeholder="0" value="{{ old('cash_payed') }}" />
                                <span class="input-group-text">{{ __('руб.') }}</span>
                                @error('cash_payed')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Внесено картой --}}
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text">Картой</span>
                                <input type="text" class="form-control text-end" id="card_payed" name="card_payed" placeholder="0" value="{{ old('card_payed') }}" />
                                <span class="input-group-text">{{ __('руб.') }}</span>
                                @error('card_payed')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Внесено переводом --}}
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text">Переводом</span>
                                <input type="text" class="form-control text-end" id="phone_payed" name="phone_payed" placeholder="0" value="{{ old('phone_payed') }}" />
                                <span class="input-group-text">{{ __('руб.') }}</span>
                                @error('phone_payed')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Внесено сертификатом --}}
                        <div class="mb-3">
                            <div class="input-group">
                                <span class="input-group-text">Сертификатом</span>
                                <input type="text" class="form-control text-end" id="cert_payed" name="cert_payed" placeholder="0" value="{{ old('cert_payed') }}" />
                                <span class="input-group-text">{{ __('руб.') }}</span>
                                @error('cert_payed')
                                    <p class="text-danger mt-2">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('shift.index') }}" class="btn btn-secondary me-1 rounded">{{ __('Назад') }}</a>
                    <button type="submit" class="btn btn-primary rounded">{{ __('Добавить') }}</button>
                </div>

                @if($errors->any())
                    <div class="text-center p-2 mb-3 mt-3 bg-danger bg-gradient text-white rounded">{{ $errors->first() }}</div>
                @endif
            </form>
        </div>

        <div class="card-footer bg-light border-0"></div>
    </div>
@endsection

@push('js2')
    <script>
        $(document).ready(function() {
            // Синхронизация цены относительно выбранной программы
            $('#item_id').change(function() {
                recalculate();
            });

            $('.recalculate').click(function() {
                recalculate();
            })

            function recalculate() {
                // Базовая цена
                const selectedOption = $('#item_id').find('option:selected');
                const basePrice = parseFloat(selectedOption.data('price'));

                // Коэффициент
                const rate = parseInt($('#rate').val());

                // Скидка в процентах
                const sale_percent = parseInt($('#sale_percent').val());

                // Выставим цену с учетом коэффициента
                const new_price = Math.round(basePrice * rate / 100);
                $('#handle_price').val(new_price);

                // Выставим скидку в рублях
                const sale_price = Math.round(new_price * sale_percent / 100);
                $('#sale_payed').val(sale_price);

                // Выставим сумму к оплате
                const total_price = Math.round(new_price - sale_price);
                $('#total').val(total_price);
            }
        });
    </script>
@endpush
