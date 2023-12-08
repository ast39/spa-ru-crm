@php
    use App\Http\Services\Helper;
@endphp

@extends('layouts.app')

@section('title', __('Добавить услугу'))

@section('content')
    @include('components/tabs/price')

    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Добавить услугу') }}</div>

        <div class="card-body bg-light">
            <form method="post" action="{{ route('dict.service.store') }}">
                @csrf
                @method('POST')

                <div class="mb-3">
                    <label for="title" class="form-label required">{{ __('Название') }}</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" />
                    @error('title')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label required">{{ __('Стоимость') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="price" name="price" placeholder="3000" value="{{ old('price') }}" />
                        <span class="input-group-text">{{ __('руб.') }}</span>
                        @error('price')
                            <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="note" class="form-label">{{ __('Заметки') }}</label>
                    <textarea  cols="10" rows="5" class="form-control" id="note" name="note">{{ old('note') }}</textarea>
                    @error('note')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label required">{{ __('Статус') }}</label>
                    <select  class="form-control form-select" id="status" name="status">
                        <option title="наличии" value="1" {{ request()->status == 1 ? 'selected' : null }}>{{ __('Доступная') }}</option>
                        <option title="Отсутствует" value="2" {{ request()->status == 2 ? 'selected' : null }}>{{ __('Закрытая') }}</option>
                    </select>
                    @error('status')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('dict.service.index') }}" class="btn btn-secondary me-1 rounded">{{ __('Назад') }}</a>
                    <button type="submit" class="btn btn-primary rounded">{{ __('Добавить') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

