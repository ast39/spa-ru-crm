@php
    use App\Http\Services\Helper;
    use App\Http\Enums\ProgramType;
@endphp

@extends('layouts.app')

@section('title', __('Добавить программу'))

@section('content')
    @include('components/tabs/price')

    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Добавить программу') }}</div>

        <div class="card-body bg-light">
            <form method="post" action="{{ route('dict.program.store') }}">
                @csrf
                @method('POST')

                <div class="mb-3">
                    <label for="title" class="form-label required">{{ __('Название') }}</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ old('title') }}" />
                    @error('name')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label required">{{ __('Для кого') }}</label>
                    <select  class="form-control form-select" id="type" name="type">
                        <option title="Для мужчин" value="{{ ProgramType::Man->value }}" {{ (request()->type ?? 0) == ProgramType::Man->value ? 'selected' : null }}>{{ __('Для мужчин') }}</option>
                        <option title="Для женщин" value="{{ ProgramType::Woman->value }}" {{ (request()->type ?? 0) == ProgramType::Woman->value ? 'selected' : null }}>{{ __('Для женщин') }}</option>
                        <option title="Для пар" value="{{ ProgramType::Pair->value }}" {{ (request()->type ?? 0) == ProgramType::Pair->value ? 'selected' : null }}>{{ __('Для пар') }}</option>
                        <option title="Для всех" value="{{ ProgramType::All->value }}" {{ (request()->type ?? 0) == ProgramType::All->value ? 'selected' : null }}>{{ __('Для всех') }}</option>
                    </select>
                    @error('type')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="period" class="form-label required">{{ __('Длительность') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="period"  name="period" placeholder="60" value="{{ old('period') }}">
                        <span class="input-group-text">{{ __('мин.') }}</span>
                        @error('period')
                            <p class="text-danger mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label required">{{ __('Стоимость') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="price" name="price" placeholder="5000" value="{{ old('price') }}" />
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
                        <option title="Работает" value="1" {{ (request()->status ?? 1) == 1 ? 'selected' : null }}>{{ __('Доступная') }}</option>
                        <option title="Уволен" value="0" {{ (request()->status ?? 1) == 2 ? 'selected' : null }}>{{ __('Закрытая') }}</option>
                    </select>
                    @error('level')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('dict.program.index') }}" class="btn btn-secondary me-1 rounded">{{ __('Назад') }}</a>
                    <button type="submit" class="btn btn-primary rounded">{{ __('Добавить') }}</button>
                </div>
            </form>
        </div>
    </div>
@endsection

