@php
    use App\Http\Services\Helper;
@endphp

@extends('layouts.app')

@section('title', __('Сотрудник') . ' : ' . $user->name)

@section('content')
    <div class="card bg-primary text-white">
        <div class="card-header">{{ __('Сотрудник') }} {{ $user->name }}</div>

        <div class="card-body bg-light">
            <table class="table table-striped table-borderless">
                <tbody>
                    <tr>
                        <th class="text-start">{{ __('Имя') }}</th>
                        <td class="text-end">{{ $user->name }}</a></td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Роль') }}</th>
                        <td class="text-end">{{ Helper::detectRole($user->roles) }}</td>
                    </tr>>
                    <tr>
                        <th class="text-start">{{ __('Логин') }}</th>
                        <td class="text-end">{{ $user->login }}</a></td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Заметки') }}</th>
                        <td class="text-end">{{ $user->note ?? ' - ' }}</td>
                    </tr>
                    <tr>
                        <th class="text-start">{{ __('Дата добавления') }}</th>
                        <td class="text-end">{{ date('d.m.Y', $user->created_at) }}</a></td>
                    </tr>
                </tbody>
            </table>
            <form method="post" action="{{ route('dict.user.destroy', $user->id) }}">
                @csrf
                @method('DELETE')

                <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                    <a href="{{ route('dict.user.index') }}" class="btn btn-secondary me-1 rounded">{{ __('Назад') }}</a>
                    <a href="{{ route('dict.user.edit', $user->id) }}" class="btn btn-warning me-1 rounded">{{ __('Изменить') }}</a>
                    <button type="submit" onclick="return confirm('{{ __('Вы уверены, что хотите удалить сотрудника?') }}')" class="btn btn-danger me-1 rounded">{{ __('Удалить') }}</button>
                    <a href="{{ route('dict.user.create') }}" class="btn btn-primary rounded">{{ __('Добавить сотрудника') }}</a>
                </div>
            </form>
        </div>
        <div class="card-footer bg-light border-0"></div>
    </div>
@endsection
