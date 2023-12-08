@php
    use App\Http\Services\Helper;
@endphp

@extends('layouts.app')

@section('title', 'Добавить позицию бара')

@section('content')
    @include('components/tabs/price')

    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Добавить позицию бара') }}</div>

        <div class="card-body bg-light">
            <form method="post" action="{{ route('dict.bar.store') }}">
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
                    <label for="portion" class="form-label required">{{ __('Объем') }}</label>
                    <input type="text" class="form-control" id="price" name="portion" value="{{ old('portion') }}" />
                    @error('portion')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label required">{{ __('Цена') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="price" name="price" placeholder="1000" value="{{ old('price') }}" />
                        <span class="input-group-text">{{ __('руб.') }}</span>
                        @error('price')
                            <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">{{ __('Остаток') }}</label>
                    <input type="text" class="form-control" id="stock" name="stock" value="{{ old('stock') }}" />
                    @error('stock')
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

                <div class="mb-3">
                    <label for="status" class="form-label required">{{ __('Статус') }}</label>
                    <select  class="form-control form-select" id="status" name="status">
                        <option title="В наличии" value="1" {{ request()->status == 1 ? 'selected' : null }}>{{ __('В наличии') }}</option>
                        <option title="Закончился" value="0" {{ request()->status == 0 ? 'selected' : null }}>{{ __('Закончился') }}</option>
                    </select>
                    @error('status')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('dict.bar.index') }}" class="btn btn-secondary me-1 rounded">{{ __('Назад') }}</a>
                    <button type="submit" class="btn btn-primary rounded">{{ __('Добавить') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

