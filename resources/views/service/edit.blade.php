@php

@endphp

@extends('layouts.app')

@section('title', __('Обновление услуги') . ' : ' . $service->title)

@section('content')
    @include('components/tabs/price')

    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Обновление услуги' . ' : ' . $service->title) }}</div>

        <div class="card-body bg-light">
            <form method="post" action="{{ route('dict.service.update', $service->service_id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label required">{{ __('Название') }}</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $service->title }}" />
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label required">{{ __('Стоимость') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="price" name="price" value="{{ $service->price }}" />
                        <span class="input-group-text">{{ __('руб.') }}</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="note" class="form-label">{{ __('Заметки') }}</label>
                    <textarea  cols="10" rows="5" class="form-control" id="note" name="note">{{ $service->note }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label required">{{ __('Статус') }}</label>
                    <select  class="form-control form-select" id="status" name="status">
                        <option title="Доступна" value="1" {{ $service->status == 1 ? 'selected' : null }}>{{ __('Доступная') }}</option>
                        <option title="Закрыта" value="0" {{ $service->status == 0 ? 'selected' : null }}>{{ __('Закрытая') }}</option>
                    </select>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('dict.service.index') }}" class="btn btn-secondary me-1 rounded">{{ __('Назад') }}</a>
                    <button type="submit" class="btn btn-primary rounded">{{ __('Сохранить') }}</button>
                </div>
            </form>

        </div>
    </div>
@endsection
