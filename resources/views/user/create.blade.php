@php
    use App\Http\Services\Helper;
    use App\Http\Enums\RoleType;
@endphp

@extends('layouts.app')

@section('title', __('Новый сотрудник'))

@section('content')
    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Новый сотрудник') }}</div>

        <div class="card-body bg-light">
            <form method="post" action="{{ route('dict.user.store') }}">
                @csrf
                @method('POST')

                <div class="mb-3">
                    <label for="name" class="form-label required">{{ __('Имя') }}</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" />
                    @error('name')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label required">{{ __('Роль') }}</label>
                    <select name="role" id="role" class="form-select form-control">
                        <option {{ request()->role == RoleType::Administrator->value ? 'selected' : '' }} value="{{ RoleType::Administrator->value }}">{{ __(RoleType::Administrator->name) }}</option>
                        <option {{ request()->role == RoleType::Master->value ? 'selected' : '' }} value="{{ RoleType::Master->value }}">{{ __(RoleType::Master->name) }}</option>
                        <option {{ request()->role == RoleType::MasterAdmin->value ? 'selected' : '' }} value="{{ RoleType::MasterAdmin->value }}">{{ __(RoleType::MasterAdmin->name) }}</option>
                    </select>
                    @error('role')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="login" class="form-label required">{{ __('Логин') }}</label>
                    <input type="text" class="form-control" id="login" name="login" value="{{ old('login') }}" />
                    @error('email')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label required">{{ __('Пароль') }}</label>
                    <input type="text" class="form-control" id="password" name="password" value="{{ old('password') }}" />
                    @error('password')
                        <p class="text-danger mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label required">{{ __('Пароль еще раз') }}</label>
                    <input type="text" class="form-control" id="password_confirmation" name="password_confirmation" value="{{ old('password_confirmation') }}" />
                    @error('password_confirmation')
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
                    <a href="{{ route('dict.user.index') }}" class="btn btn-secondary me-1 rounded">{{ __('Назад') }}</a>
                    <button type="submit" class="btn btn-primary rounded">{{ __('Добавить') }}</button>
                </div>
            </form>
        </div>
        <div class="card-footer bg-light border-0"></div>
    </div>
@endsection

