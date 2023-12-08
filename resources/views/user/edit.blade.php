@php
    use App\Http\Services\Helper;
    use App\Http\Enums\RoleType;
@endphp

@extends('layouts.app')

@section('title', __('Обновление сотрудника') . ': ' . $user->name)

@section('content')
    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Обновление сотрудника') . ' : ' . $user->name }}</div>

        <div class="card-body bg-light">
            <form method="post" action="{{ route('dict.user.update', $user->id) }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label required">{{ __('Имя') }}</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" />
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label required">{{ __('Роль') }}</label>
                    <select name="role" id="role" class="form-select form-control">
                        <option {{ Helper::roleSum($user->roles) == RoleType::Administrator->value ? 'selected' : '' }} value="{{ RoleType::Administrator->value }}">{{ __(RoleType::Administrator->name) }}</option>
                        <option {{ Helper::roleSum($user->roles) == RoleType::Master->value ? 'selected' : '' }} value="{{ RoleType::Master->value }}">{{ __(RoleType::Master->name) }}</option>
                        <option {{ Helper::roleSum($user->roles) == RoleType::MasterAdmin->value ? 'selected' : '' }} value="{{ RoleType::MasterAdmin->value }}">{{ __(RoleType::MasterAdmin->name) }}</option>
                    </select>
                    @error('role')
                    <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="login" class="form-label required">{{ __('Логин') }}</label>
                    <input type="text" class="form-control" id="login" name="login" value="{{ $user->login }}" />
                </div>

                <div class="mb-3">
                    <label for="note" class="form-label">{{ __('Заметки') }}</label>
                    <textarea  cols="10" rows="5" class="form-control" id="note" name="note">{{ $user->note }}</textarea>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('dict.user.index') }}" class="btn btn-secondary me-1 rounded">{{ __('Назад') }}</a>
                    <button type="submit" class="btn btn-primary rounded">{{ __('Сохранить') }}</button>
                </div>
            </form>

        </div>
        <div class="card-footer bg-light border-0"></div>
    </div>
@endsection
