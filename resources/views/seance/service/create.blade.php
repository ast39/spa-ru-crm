@php
    use App\Http\Services\Helper;
    use App\Http\Enums\PayType;
@endphp

@extends('layouts.app')

@section('title', __('Продажа') . ' : ' . __('Услуги'))

@section('content')
    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Продажа') . ' : ' . __('Услуги') }}</div>

        <div class="card-body bg-light">
            <form method="post" action="{{ route('shift.service.store') }}">
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
                            <option title="{{ $master->name }}" {{ (request()->id ?? 0) == $master->id ? 'selected' : '' }} value="{{ $master->id }}">{{ $master->name }}</option>
                        @endforeach
                    </select>
                    @error('master_id')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="accordion">
                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button bg-light collapsed text-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                {{ __('Услуги') }}
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

                <div class="mb-3">
                    <label for="guest" class="form-label">{{ __('Гость') }}</label>
                    <input type="text" class="form-control" id="guest" name="guest" placeholder="{{ __('Имя гостя') }}" value="{{ old('guest') }}" />
                    @error('guest')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
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
                    <label for="note" class="form-label">{{ __('Заметки') }}</label>
                    <textarea  cols="10" rows="5" class="form-control" id="note" name="note">{{ old('note') }}</textarea>
                    @error('note')
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
