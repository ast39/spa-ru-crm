@php
    use App\Http\Enums\ProgramType;
@endphp

@extends('layouts.app')

@section('title', __('Обновление программы') . ' : ' . $program->title)

@section('content')
    @include('components/tabs/price')

    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Обновление программы' . ' : ' . $program->title) }}</div>

        <div class="card-body bg-light">
            <form method="post" action="{{ route('dict.program.update', $program->program_id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="title" class="form-label required">{{ __('Название') }}</label>
                    <input type="text" class="form-control" id="title" name="title" value="{{ $program->title }}" />
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label required">{{ __('Для кого') }}</label>
                    <select  class="form-control form-select" id="type" name="type">
                        <option title="Для мужчин" value="{{ ProgramType::Man->value }}" {{ ($program->type ?? 0) == ProgramType::Man->value ? 'selected' : null }}>{{ __('Для мужчин') }}</option>
                        <option title="Для женщин" value="{{ ProgramType::Woman->value }}" {{ ($program->type ?? 0) == ProgramType::Woman->value ? 'selected' : null }}>{{ __('Для женщин') }}</option>
                        <option title="Для пар" value="{{ ProgramType::Pair->value }}" {{ ($program->type ?? 0) == ProgramType::Pair->value ? 'selected' : null }}>{{ __('Для пар') }}</option>
                        <option title="Для всех" value="{{ ProgramType::All->value }}" {{ ($program->type ?? 0) == ProgramType::All->value ? 'selected' : null }}>{{ __('Для всех') }}</option>
                    </select>
                    @error('type')
                    <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="period" class="form-label required">{{ __('Длительность') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="period" name="period" value="{{ $program->period }}" />
                        <span class="input-group-text">{{ __('мин.') }}</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="price" class="form-label required">{{ __('Стоимость') }}</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="price" name="price" value="{{ $program->price }}" />
                        <span class="input-group-text">{{ __('руб.') }}</span>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="note" class="form-label">{{ __('Заметки') }}</label>
                    <textarea  cols="10" rows="5" class="form-control" id="note" name="note">{{ $program->note }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="status" class="form-label required">{{ __('Статус') }}</label>
                    <select  class="form-control form-select" id="status" name="status">
                        <option title="Открыта" value="1" {{ $program->status == 1 ? 'selected' : null }}>{{ __('Доступная') }}</option>
                        <option title="Закрыта" value="0" {{ $program->status == 2 ? 'selected' : null }}>{{ __('Закрытая') }}</option>
                    </select>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('dict.program.index') }}" class="btn btn-secondary me-1 rounded">{{ __('Назад') }}</a>
                    <button type="submit" class="btn btn-primary rounded">{{ __('Сохранить') }}</button>
                </div>
            </form>

        </div>
    </div>
@endsection

