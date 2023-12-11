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
            <form method="post" action="{{ route('shift.service.update', $seance->record_id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="admin_id" class="form-label required">{{ __('Администратор') }}</label>
                    <input type="text" class="form-control disabled" disabled id="admin_id" name="admin_id" value="{{ $seance->admin->name }}" />
                    @error('admin_id')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="master_id" class="form-label required">{{ __('Мастер') }}</label>
                    <select name="master_id" id="master_id" class="form-select form-control">
                        @foreach($masters as $master)
                            <option title="{{ $master->name }}" {{ $seance->master->id == $master->id ? 'selected' : '' }} value="{{ $master->id }}">{{ $master->name }}</option>
                        @endforeach
                    </select>
                    @error('master_id')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>


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
                    <tr>
                        <td class="text-start">{{ $seance->service->title }}</td>
                        <td class="text-center">{{ __('шт') }}</td>
                        <td class="text-center cb"><input class="form-control" name="amount" type="text" value="{{ $seance->amount }}" /></td>
                        <td class="text-center cb"><input class="form-check-input" name="gift" type="checkbox" {{ $seance->gift > 0 ? 'checked="checked"' : '' }} /></td>
                    </tr>
                    </tbody>
                </table>

                <div class="mb-3">
                    <label for="guest" class="form-label">{{ __('Гость') }}</label>
                    <input type="text" class="form-control" id="guest" name="guest" placeholder="{{ __('Имя гостя') }}" value="{{ $seance->guest }}" />
                </div>

                <div class="mb-3">
                    <label for="sale" class="form-label">{{ __('Скидка') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="sale" name="sale" placeholder="0" value="{{ $seance->sale }}" />
                        <span class="input-group-text">{{ __('%') }}</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="pay_type" class="form-label required">{{ __('Форма оплаты') }}</label>
                    <select name="pay_type" id="pay_type" class="form-select form-control">
                        <option title="Наличка" {{ $seance->pay_type == PayType::Cash->value ? 'selected' : '' }} value="{{ PayType::Cash->value }}">{{ Helper::payType(PayType::Cash->value) }}</option>
                        <option title="Карта" {{ $seance->pay_type == PayType::Card->value ? 'selected' : '' }} value="{{ PayType::Card->value }}">{{ Helper::payType(PayType::Card->value) }}</option>
                        <option title="Перевод" {{ $seance->pay_type == PayType::Phone->value ? 'selected' : '' }} value="{{ PayType::Phone->value }}">{{ Helper::payType(PayType::Phone->value) }}</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="note" class="form-label">{{ __('Заметки') }}</label>
                    <textarea  cols="10" rows="5" class="form-control" id="note" name="note">{{ $seance->note }}</textarea>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('shift.index') }}" class="btn btn-secondary me-1 rounded">{{ __('Назад') }}</a>
                    <button type="submit" class="btn btn-primary rounded">{{ __('Сохранить') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
