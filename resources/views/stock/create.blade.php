@php
    use App\Http\Services\Helper;
@endphp

@extends('layouts.app')

@section('title', 'Добавить движение по складу')

@section('content')
    @include('components/tabs/price')

    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Добавить движение по складу') }}</div>

        <div class="card-body bg-light">
            <form method="post" action="{{ route('stock.store') }}">
                @csrf
                @method('POST')

                <div class="mb-3">
                    <label for="item_id" class="form-label required">{{ __('Товар') }}</label>
                    <select  class="form-control form-select" id="item_id" name="item_id">
                        @forelse($bar as $item)
                            <option value="{{ $item->item_id }}" {{ old('item_id') == $item->item_id ? 'selected' : null }}>{{ $item->title }} - {{ $item->portion }}</option>
                        @empty
                        @endforelse
                    </select>
                    @error('item_id')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="value" class="form-label required">{{ __('Кол-во') }}</label>
                    <input type="text" class="form-control" id="value" name="value" value="{{ old('value') }}" />
                    @error('value')
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
                    <a href="{{ route('stock.index') }}" class="btn btn-secondary me-1 rounded">{{ __('Назад') }}</a>
                    <button type="submit" class="btn btn-primary rounded">{{ __('Добавить') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection
