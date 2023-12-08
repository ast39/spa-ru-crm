@php
    use App\Http\Services\Helper;
    use App\Http\Enums\PercentType;
@endphp

@extends('layouts.app')

@section('title', __('Обновление администратора') . ' : ' . $admin->name)

@section('content')
    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Обновление администратора')  . ' : ' . $admin->name }}</div>

        <div class="card-body bg-light">
            <form method="post" action="{{ route('dict.admin.update', $admin->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label required">{{ __('Имя') }}</label>
                    <input type="text" class="form-control disabled" disabled id="name" name="name" value="{{ $admin->name }}" />
                </div>

                <div class="mb-3">
                    <label for="percent_program" class="form-label required">{{ __('Процент от программы') }}</label>
                    <input type="text" class="form-control" id="percent_program" name="percent_program" value="{{ Helper::adminPercent($admin->roles, PercentType::Program->value) }}" />
                </div>

                <div class="mb-3">
                    <label for="percent_service" class="form-label required">{{ __('Процент от услуг') }}</label>
                    <input type="text" class="form-control" id="percent_service" name="percent_service" value="{{ Helper::adminPercent($admin->roles, PercentType::Service->value) }}" />
                </div>

                <div class="mb-3">
                    <label for="percent_bar" class="form-label required">{{ __('Процент от бара') }}</label>
                    <input type="text" class="form-control" id="percent_bar" name="percent_bar" value="{{ Helper::adminPercent($admin->roles, PercentType::Bar->value) }}" />
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label required">{{ __('Логин') }}</label>
                    <input type="text" class="form-control disabled" disabled id="email" name="email" value="{{ $admin->login }}" />
                </div>

                <div class="mb-3">
                    <label for="note" class="form-label">{{ __('Заметки') }}</label>
                    <textarea  cols="10" rows="5" class="form-control disabled" disabled id="note" name="note">{{ $admin->note }}</textarea>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('dict.admin.index') }}" class="btn btn-secondary me-1 rounded">{{ __('Назад') }}</a>
                    <button type="submit" class="btn btn-primary rounded">{{ __('Сохранить') }}</button>
                </div>
            </form>

        </div>
        <div class="card-footer bg-light border-0"></div>
    </div>
@endsection

