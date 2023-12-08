@php

@endphp

@extends('layouts.app')

@section('title', __('Обновление') . ' : ' . $bar->title)

@section('content')
    @include('components/tabs/price')

    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Обновление' . ' : ' . $bar->title) }}</div>

        <div class="card-body bg-light">
            <form method="post" action="{{ route('dict.bar.update', $bar->item_id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label required">{{ __('Название') }}</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $bar->title }}" />
                </div>

                <div class="mb-3">
                    <label for="portion" class="form-label required">{{ __('Объем') }}</label>
                    <input type="text" class="form-control" id="portion" name="portion" value="{{ $bar->portion }}" />
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label required">{{ __('Цена') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="price" name="price" value="{{ $bar->price }}" />
                        <span class="input-group-text">{{ __('руб.') }}</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label required">{{ __('Остаток') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="stock" name="stock" value="{{ $bar->stock }}" />
                        <span class="input-group-text">{{ __('по') }} {{ $bar->portion }}</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="note" class="form-label">{{ __('Заметки') }}</label>
                    <textarea  cols="10" rows="5" class="form-control" id="note" name="note">{{ $bar->note }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label required">{{ __('Статус') }}</label>
                    <select  class="form-control form-select" id="status" name="status">
                        <option title="В наличии" value="1" {{ $bar->status == 1 ? 'selected' : null }}>{{ __('В наличии') }}</option>
                        <option title="Закончился" value="0" {{ $bar->status == 0 ? 'selected' : null }}>{{ __('Закончился') }}</option>
                    </select>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('dict.bar.index') }}" class="btn btn-secondary me-1 rounded">{{ __('Назад') }}</a>
                    <button type="submit" class="btn btn-primary rounded">{{ __('Сохранить') }}</button>
                </div>
            </form>

        </div>
    </div>
@endsection
